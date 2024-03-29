## Running UI Tests
   oCIS IDP configuration   
   ```bash
   # configure idp for ocis https://owncloud.dev/services/idp/
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
   PROXY_ENABLE_BASIC_AUTH=true OCIS_INSECURE=true PROXY_HTTP_ADDR=0.0.0.0:9200 OCIS_URL=https://host.docker.internal:9200 PROXY_TRANSPORT_TLS_KEY=</path/of/ocis.pem> PROXY_TRANSPORT_TLS_CERT=</path/of/ocis.crt> ./ocis/bin/ocis server
   ```
   To run Behat tests you have to add some code in moodle source code for ssl proxy support 
   ```bash
sed -i "s/\$CFG->dataroot = \$CFG->behat_dataroot;/\$CFG->dataroot = \$CFG->behat_dataroot;\n\t\t\$CFG->sslproxy = \$CFG->behat_sslproxy;/" /<path-to-moodle>/lib/setup.php
   ```
   configure traefik and test environments
   ```bash
   cd moodle-docker
   mkdir -p traefik/configs traefik/certificates
   cat >> traefik/configs/tls.yml <<'EOF'
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
   export MOODLE_DOCKER_BROWSER=chrome:94.0
   ```

   change in `config.php` for ssl support
   ```bash
   sed -i "s/\$CFG->wwwroot\s*=\s*\"http:\/\/{\$host}\";/\$CFG->sslproxy = true;\n\$CFG->wwwroot = \"https:\/\/{\$host}\";/" $MOODLE_DOCKER_WWWROOT/config.php
   sed -i "s/\$CFG->behat_wwwroot\s*=\s*'http:\/\/webserver';/\$CFG->behat_sslproxy = true;\n\$CFG->behat_wwwroot = 'https:\/\/moodle.webserver:8000';/" $MOODLE_DOCKER_WWWROOT/config.php
   ```

   add `capabilities` to the `$CFG->behat_profiles` array in `$MOODLE_DOCKER_WWWROOT/config.php`
   that will make the Chrome browser accept self-signed certificates.


   these lines

   ```php
   $CFG->behat_profiles = array(
       'default' => array(
          'browser' => getenv('MOODLE_DOCKER_BROWSER'),
          'wd_host' => 'http://selenium:4444/wd/hub',
       ),
   );
   ```
   should become:
   ```php
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
   # allow container to access docker host via 'host.docker.internal'
   cp $MOODLE_DOCKER_WWWROOT/repository/ocis/tests/local.example.yml local.yml
   # run moodle
   bin/moodle-docker-compose up -d
   # if oCIS will run with a self signed certificate copy that into the moodle container and make it trust it
   bin/moodle-docker-compose cp </path/of/ocis.crt> webserver:/usr/local/share/ca-certificates/
   bin/moodle-docker-compose cp traefik/certificates/server.crt webserver:/usr/local/share/ca-certificates/
   bin/moodle-docker-compose exec webserver update-ca-certificates
   bin/moodle-docker-compose cp </path/of/ocis.crt> selenium:/usr/local/share/ca-certificates/
   bin/moodle-docker-compose cp traefik/certificates/server.crt selenium:/usr/local/share/ca-certificates/
   bin/moodle-docker-compose exec selenium update-ca-certificates
   bin/moodle-docker-wait-for-db
   # Initialize behat environment
   bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/init.php
   # run test
   bin/moodle-docker-compose exec webserver php admin/tool/behat/cli/run.php --tags=@ocis
   ```
   ### other ways to run behat tests
   https://moodledev.io/general/development/tools/behat/running#run-behat-tests
      