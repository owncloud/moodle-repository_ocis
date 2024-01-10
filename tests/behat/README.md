## Running UI Test


   To run Behat tests you have to configure some settings in moodle

   ```php
        cd moodle
        // Now we can begin switching $CFG->X for $CFG->behat_X.
        $CFG->wwwroot = $CFG->behat_wwwroot;
        $CFG->prefix = $CFG->behat_prefix;
        $CFG->dataroot = $CFG->behat_dataroot;
         # add some code below above code in moodle/lib/setup.php
        // Now we can begin switching $CFG->X for $CFG->behat_X.
        $CFG->wwwroot = $CFG->behat_wwwroot;
        $CFG->prefix = $CFG->behat_prefix;
        $CFG->dataroot = $CFG->behat_dataroot;
        $CFG->sslproxy = $CFG->behat_sslproxy;

        // change in lib/behat/classes/util.php
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // to
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   ```
   configure traefik and test enviroments
   ```bash
      cd moodle-docker
      mkdir -p "traefik/configs traefik/certificates"
      cd traefik
      cat >> tls.yml <<'EOF'
      tls:
        stores:
           default:
             defaultCertificate:
                certFile: /certificates/server.crt
                keyFile: /certificates/server.key
      EOF
      # some general settings for moodle
      export MOODLE_DOCKER_WWWROOT=<path-of-your-moodle-source-code>
      export MOODLE_DOCKER_DB=pgsql
      export MOODLE_DOCKER_PHP_VERSION=8.1
      export MOODLE_DOCKER_WEB_HOST=host.docker.internal
      export MOODLE_DOCKER_WEB_PORT=8000
      export MOODLE_DOCKER_SELENIUM_VNC_PORT=5900
      export MOODLE_DOCKER_BROWSER=chrome:latest
      cd ..
      cp config.docker-template.php $MOODLE_DOCKER_WWWROOT/config.php
      cd ..
      cd moodle
   ```

   configure moodle to run with certificate and setup test url
   ```bash
      $CFG->wwwroot   = "http://{$host}";
      # replace above code in config.php with below code
      $CFG->sslproxy = true;
      $CFG->wwwroot   = "https://{$host}";
   ```
   ```bash
      $CFG->behat_wwwroot   = 'http://webserver';
      # replace above code in config.php with below code
      $CFG->behat_sslproxy = true;
      $CFG->behat_wwwroot   = 'https://moodle.webserver:8000';
   ```
   ```php
      $CFG->behat_profiles = array(
          'default' => array(
             'browser' => getenv('MOODLE_DOCKER_BROWSER'),
             'wd_host' => 'http://selenium:4444/wd/hub',
          ),
      );
      # replace above code in config.php with below code
      $CFG->behat_profiles = array(
           'default' => array(
              'browser' => getenv('MOODLE_DOCKER_BROWSER'),
              'wd_host' => 'http://selenium:4444/wd/hub',
                'capabilities' =>
                       [
                           'acceptSslCerts'=> true,
                            'extra_capabilities' =>
                            [ 'chromeOptions' =>
                            [ 'args' =>
                                  [ '--ignore-certificate-errors']
                            ]
                          ]
                ]
                ),
             );
   ```
   configure the test container
   ```bash
      cd ..
      cd moodle-docker
      # allow container to access docker host via 'host.docker.internal'
      cp $MOODLE_DOCKER_WWWROOT/repository/ocis/tests/behat/local.example.yml local.yml
      # run moodle
      bin/moodle-docker-compose up -d
      # if oCIS will run with a self signed certificate copy that into the moodle container and make it trust it
      bin/moodle-docker-compose cp </path/of/ocis.crt> webserver:/usr/local/share/ca-certificates/
      bin/moodle-docker-compose cp traefik/certificates/server.crt webserver:/usr/local/share/ca-certificates/
      bin/moodle-docker-compose exec webserver update-ca-certificates
      bin/moodle-docker-compose cp </path/of/ocis.crt> selenium:/usr/local/share/ca-certificates/
      bin/moodle-docker-compose cp traefik/certificates/server.crt selenium:/usr/local/share/ca-certificates/
      bin/moodle-docker-compose exec selenium update-ca-certificates
   ```
   ```bash
      #configure idp for ocis https://owncloud.dev/services/idp/
      # in ~/.ocis/config/idp.yml add new client
      - id: moodle-ocis-integration
         name: Integration app
         trusted: false
         secret: UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh
         redirect_uris:
            - https://host.docker.internal:8000/
            - https://host.docker.internal:8000/admin/oauth2callback.php
            - https://moodle.webserver:8000/
            - https://moodle.webserver:8000/admin/oauth2callback.php
         origins: []
         application_type: "web"
      # start ocis
      PROXY_ENABLE_BASIC_AUTH=true OCIS_INSECURE=true PROXY_HTTP_ADDR=0.0.0.0:9200 OCIS_URL=https://host.docker.internal:9200 PROXY_TRANSPORT_TLS_KEY=ocis.pem PROXY_TRANSPORT_TLS_CERT=ocis.crt ./ocis/bin/ocis server
   ```
   ```bash
      # Initialize behat environment
      bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/init.php
      # run test
      bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/run.php --tags=@ocis
   ```
   ### other ways to run behat tests
   https://moodledev.io/general/development/tools/behat/running#run-behat-tests
      