# Integration of Moodle and [oCIS](https://doc.owncloud.com/ocis/next/)

A [Moodle repository](https://docs.moodle.org/402/en/Repositories) that makes files stored in oCIS accessible through the [Moodle file-picker](https://docs.moodle.org/402/en/File_picker).

:exclamation: This plugin is still under heavy development and is not yet ready for production use! :exclamation:

## Minimum requirement
- [oCIS PHP SDK](https://github.com/owncloud/ocis-php-sdk/)
- moodle 4.2
- PHP 8.1
- with oCIS 4.0 only the "internal" linking mode is supported
- a version of oCIS that implements the new sharing API will be needed for the "reference" and "controlled link" modes

## Main features

### 1. Authentication
The existing OAuth2 implementation in Moodle does support OpenID connect, so a custom Oauth2 service is used to connect to oCIS.

### 2. Link files between Moodle & oCIS using the [Moodle file-picker](https://docs.moodle.org/402/en/File_picker)

There are three different modes for the Moodle user to link files from oCIS to Moodle. Only files stored in the personal space will be accessible by Moodle.

1. **Internal** (Make a copy of the file)
   In this case the file is copied from oCIS and stored within the Moodle file system.
2. **Reference**: (Link to the file)
   In this case a public link of the file is created in oCIS and Moodle stores this link
3. **Controlled Link**: (Create an access controlled link to the file)
   For this to work a special oCIS account needs to be connected to Moodle that will be used as a System account. If the user selects the "Controlled Link" option, the file will first be copied to a Moodle specific folder in oCIS, then shared to the System account and Moodle will access it through the System account.

## Installation
1. TLS certificate
   The TLS certificates of oCIS need to be trusted by the server running moodle. If your oCIS instance has already a trusted certificate you can skip this step. 
   If you are using self-signed certificates you need to copy them to the moodle server and make it trust them. e.g. on Debian based systems to run oCIS on `https://host.docker.internal:9200`:
   1. create a TLS certificate
      ```bash
      openssl req -x509  -newkey rsa:2048 -keyout ocis.pem -out ocis.crt -nodes -days 365 -subj '/CN=host.docker.internal'
      ```
   2. make 'host.docker.internal' resolve to the IP 127.0.0.1 on the docker host machine
      ```bash
      sudo sh -c "echo '127.0.0.1 host.docker.internal' >> /etc/hosts"
      ```
2. Install moodle and this plugin
    - Development environment with docker:
      ```bash
      # get moodle from git
      git clone https://github.com/moodle/moodle.git --branch MOODLE_402_STABLE --single-branch --depth=1
      # get and install this plugin including it's dependencies
      cd moodle/repository/
      git clone https://github.com/owncloud/moodle-repository_ocis.git ocis
      cd ocis
      composer install
      # get docker containers for moodle developers
      cd ../../../
      git clone https://github.com/moodlehq/moodle-docker.git
      cd moodle-docker
      # some general settings for moodle
      export MOODLE_DOCKER_WWWROOT=<path-of-your-moodle-source-code>
      export MOODLE_DOCKER_DB=pgsql
      export MOODLE_DOCKER_PHP_VERSION=8.1
      cp config.docker-template.php $MOODLE_DOCKER_WWWROOT/config.php
      # allow container to access docker host via 'host.docker.internal'
      cat > local.yml <<'EOF'
      services:
        webserver:
          extra_hosts:
            - host.docker.internal:host-gateway
          environment:
            MOODLE_DISABLE_CURL_SECURITY: "true" # optional, but useful for testing on localhost or host.docker.internal
            MOODLE_OCIS_URL: "https://host.docker.internal:9200" # optional, used to create OAuth 2 services and repository instance during installation
            MOODLE_OCIS_CLIENT_ID: "xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69"  # optional, used to create OAuth 2 services and repository instance during installation
            MOODLE_OCIS_CLIENT_SECRET: "UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh" # optional, used to create OAuth 2 services and repository instance during installation
      EOF
      # run moodle
      bin/moodle-docker-compose up -d
      # if oCIS will run with a self signed certificate copy that into the moodle container and make it trust it
      bin/moodle-docker-compose cp </path/of/ocis.crt> webserver:/usr/local/share/ca-certificates/
      bin/moodle-docker-compose exec webserver update-ca-certificates
      bin/moodle-docker-wait-for-db
      bin/moodle-docker-compose exec webserver php admin/cli/install_database.php --agree-license --fullname="Docker moodle" --shortname="docker_moodle" --summary="Docker moodle site" --adminpass="admin" --adminemail="admin@example.com"
      ```
      moodle will now be available under http://localhost:8000
    - Other installation methods:
        - [Install and run moodle](https://docs.moodle.org/402/en/Installing_Moodle)
        - copy / clone the code of the repository into the `repository/ocis` folder of your moodle installation
        - run `composer install` inside of the `repository/ocis` folder
3. Install & run [oCIS](https://doc.owncloud.com/ocis/next/quickguide/quickguide.html)
   If you have created an own TLS certificate in point 1, run oCIS using this certificate: 
        ```bash
        OCIS_INSECURE=true \
        PROXY_HTTP_ADDR=0.0.0.0:9200 \
        OCIS_URL=https://host.docker.internal:9200 \
        PROXY_TRANSPORT_TLS_KEY=</path/of/ocis.pem> \
        PROXY_TRANSPORT_TLS_CERT=</path/of/ocis.crt> \
        ./ocis server
        ```
        :exclamation: Having set `OCIS_INSECURE=true` is not recommended for production use! :exclamation:
4. Login to moodle as "admin"
5. If you run oCIS on `localhost` or any local IP address go to the "HTTP security" page ("Site administration" > "General" > "Security" > "HTTP security") and delete the IP address and host-name you are using from the "cURL blocked hosts list" list. E.g if you have been following the examples above and using `https://host.docker.internal:9200` as the address for oCIS, you will have to delete `172.16.0.0/12` from the list. 
6. If you run oCIS on any port other than `443` go to the "HTTP security" page ("Site administration" > "General" > "Security" > "HTTP security") and add the port you are using to the "cURL allowed ports list" list. E.g. if you have been following the examples above add `9200` to the list.
7. Go to the "OAuth 2 services" page ("Site administration" > "Server" > "OAuth 2 services")
8. Create a new "Custom" service
   1. Choose any name you like
   2. Set "Client ID".
      If moodle runs on `localhost` the ID `xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69` can be used for testing, else another client need to be set up in the [oCIS IDP](https://owncloud.dev/services/idp/configuration/)
   3. Set "Client secret"
      If moodle runs on `localhost` the secret `UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh` can be used for testing, else another client need to be set up in the [oCIS IDP](https://owncloud.dev/services/idp/configuration/)
   4. Set "Service base URL" to the URL of your oCIS instance. An instance with a trusted TLS certificate is required, e.g. `https://host.docker.internal:9200`
   5. Set "Scopes included in a login request for offline access." to `openid offline_access email profile`
   6. Save the changes
9. To use webfinger for discovery of the oCIS server that is assigned to a specific user:
    1. Click on the "Configure endpoints" icon of the newly created service
    2. Create a new endpoint with the name `webfinger_endpoint` and the webfinger URL e.g. `<service-base-url>/.well-known/webfinger`
10. Go to the "Manage repositories" page ("Site administration" > "Plugins" > "Repositories" > "ownCloud Infinite Scale repository")
11. Create a new repository instance
12. Choose a name you like
13. Select the Oauth2 service you created before
14. Save the settings
15. Navigate to any page where there is a file picker e.g. "My courses" > "Create course" > "Course image"
16. "Add" a new file
17. Select the repository you have created earlier
18. Click "Login in to your account"
19. Go through the login / oauth process
20. Now you should be able to see the content of your personal space and select files from there


## Development

### Auto-provisioning

To reduce the setup steps specially when doing development and running automated tests these environment variables can be set to auto-provision the plugin:

- `MOODLE_DISABLE_CURL_SECURITY="true"` to disable and delete all curl security checks, useful for testing on localhost or host.docker.internal
- `MOODLE_OCIS_URL`, `MOODLE_OCIS_CLIENT_ID`, `MOODLE_OCIS_CLIENT_SECRET`, `MOODLE_OCIS_LOGO_URL` to create OAuth 2 services and repository instance during installation. Note: the auto-provisioning will be triggered only if all of `MOODLE_OCIS_URL`, `MOODLE_OCIS_CLIENT_ID`, `MOODLE_OCIS_CLIENT_SECRET` variables are set.

### Run tests

#### Style check
To meet the [moodle coding style](https://moodledev.io/general/development/policies/codingstyle), we are using phpcs with the [moodle ruleset](https://moodledev.io/general/development/tools/phpcs).
```bash
make test-php-style
make test-php-style-fix
```
