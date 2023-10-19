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
1. Install moodle and this plugin
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
      EOF
      # run moodle
      bin/moodle-docker-compose up -d
      bin/moodle-docker-wait-for-db
      bin/moodle-docker-compose exec webserver php admin/cli/install_database.php --agree-license --fullname="Docker moodle" --shortname="docker_moodle" --summary="Docker moodle site" --adminpass="admin" --adminemail="admin@example.com"
      ```
      moodle will now be available under http://localhost:8000 
    - Other installation methods:
        - [Install and run moodle](https://docs.moodle.org/402/en/Installing_Moodle)
        - copy / clone the code of the repository into the `repository/ocis` folder of your moodle installation
        - run `composer install` inside of the `repository/ocis` folder
2. Install [oCIS](https://doc.owncloud.com/ocis/next/quickguide/quickguide.html)
   - NOTE: the TLS certificates of oCIS need to be trusted by the server running moodle, so if you are using self-signed certificates you need to copy them to the moodle server and make it trust them. e.g. on Debian based systems to run oCIS on `https://host.docker.internal:9200`:
     1. create a TLS certificate
        ```bash
        openssl req -x509  -newkey rsa:2048 -keyout ocis.pem -out ocis.crt -nodes -days 365 -subj '/CN=host.docker.internal'
        ```
     2. make 'host.docker.internal' resolve to the IP 127.0.0.1 on the docker host machine
        ```bash
        sudo sh -c "echo '127.0.0.1 host.docker.internal' >> /etc/hosts"
        ```
     3. run oCIS using this certificate: 
        ```bash
        OCIS_INSECURE=true \
        PROXY_HTTP_ADDR=0.0.0.0:9200 \
        OCIS_URL=https://host.docker.internal:9200 \
        PROXY_TRANSPORT_TLS_KEY=./ocis.pem \
        PROXY_TRANSPORT_TLS_CERT=./ocis.crt \
        ./ocis server
        ```
        :exclamation: Having set `OCIS_INSECURE=true` is not recommended for production use! :exclamation:
     4. copy the certificate file to the store of the oCIS server and make the system trust it
        - if oCIS runs on the same server as moodle:
          ```bash
          sudo cp ocis.crt /usr/local/share/ca-certificates
          sudo update-ca-certificates
          ```
        - if moodle runs in the development docker container from point 1:
          ```bash
          docker cp ocis.crt moodle-docker-webserver-1:/usr/local/share/ca-certificates/
          docker exec  moodle-docker-webserver-1 update-ca-certificates
          ```
3. Login to moodle as "admin"
4. If you run oCIS on `localhost` or any local IP address go to the "HTTP security" page ("Site administration" > "General" > "Security" > "HTTP security") and delete the IP address and host-name you are using from the "cURL blocked hosts list" list. E.g if you have been following the examples above and using `https://host.docker.internal:9200` as the address for oCIS, you will have to delete `172.16.0.0/12` from the list. 
5. If you run oCIS on any port other than `443` go to the "HTTP security" page ("Site administration" > "General" > "Security" > "HTTP security") and add the port you are using to the "cURL allowed ports list" list. E.g. if you have been following the examples above add `9200` to the list.
6. Go to the "OAuth 2 services" page ("Site administration" > "Server" > "OAuth 2 services")
7. Create a new "Custom" service
   1. Choose any name you like
   2. Set "Client ID".
      If moodle runs on `localhost` the ID `xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69` can be used for testing, else another client need to be set up in the [oCIS IDP](https://owncloud.dev/services/idp/configuration/)
   3. Set "Client secret"
      If moodle runs on `localhost` the secret `UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh` can be used for testing, else another client need to be set up in the [oCIS IDP](https://owncloud.dev/services/idp/configuration/)
   4. Set "Service base URL" to the URL of your oCIS instance. An instance with a trusted TLS certificate is required, e.g. `https://host.docker.internal:9200`
   5. Set "Scopes included in a login request for offline access." to `openid offline_access email profile`
   6. Save the changes
8. To use webfinger for discovery of the oCIS server that is assigned to a specific user:
    1. Click on the "Configure endpoints" icon of the newly created service
    2. Create a new endpoint with the name `webfinger_endpoint` and the webfinger URL e.g. `<service-base-url>/.well-known/webfinger`
9. Go to the "Manage repositories" page ("Site administration" > "Plugins" > "Repositories" > "Manage repositories")
10. Set the "ownCloud Infinite Scale repository" to "Enabled and visible"
11. Save the settings
12. Go again into the Settings page of the "ownCloud Infinite Scale repository"
13. Create a new repository instance
14. Choose a name you like
15. Select the Oauth2 service you created before
16. Save the settings
17. Navigate to any page where there is a file picker e.g. "My courses" > "Create course" > "Course image"
18. "Add" a new file
19. Select the repository you have created earlier
20. Click "Login in to your account"
21. Go through the login / oauth process
22. Now you should be able to see the content of your personal space and select files from there
