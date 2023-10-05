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

1. Install [ocis](https://doc.owncloud.com/ocis/next/quickguide/quickguide.html)
   - NOTE: if you want to run ocis on `localhost` you need to create TLS certificates, make your system trust them and start ocis with those certificates. e.g. on Debian based systems:
     ```bash
     openssl req -x509  -newkey rsa:2048 -keyout ocis.pem -out ocis.crt -nodes -days 365 -subj '/CN=localhost'
     sudo cp ocis.crt /usr/local/share/ca-certificates
     sudo update-ca-certificates
     OCIS_INSECURE=true \
     PROXY_HTTP_ADDR=0.0.0.0:9200 \
     OCIS_URL=https://localhost:9200 \
     PROXY_TRANSPORT_TLS_KEY=./ocis.pem \
     PROXY_TRANSPORT_TLS_CERT=./ocis.crt \
     ./ocis server
     ```
     :exclamation: Having set `OCIS_INSECURE=true` is not recommended for production use! :exclamation:
2. Install moodle and this plugin
   - Development environment with docker
     ```bash
     git clone https://github.com/moodle/moodle.git --branch MOODLE_402_STABLE --single-branch --depth=1
     cd moodle/repository/
     git clone https://github.com/owncloud/moodle-repository_ocis.git ocis
     cd ocis
     composer install
     cd ../../../
     git clone https://github.com/moodlehq/moodle-docker.git
     cd moodle-docker
     export MOODLE_DOCKER_WWWROOT=<path-of-your-moodle-source-code>
     export MOODLE_DOCKER_DB=pgsql
     export MOODLE_DOCKER_PHP_VERSION=8.1
     cp config.docker-template.php $MOODLE_DOCKER_WWWROOT/config.php
     bin/moodle-docker-compose up -d
     bin/moodle-docker-wait-for-db
     bin/moodle-docker-compose exec webserver php admin/cli/install_database.php --agree-license --fullname="Docker moodle" --shortname="docker_moodle" --summary="Docker moodle site" --adminpass="admin" --adminemail="admin@example.com"
     ```
   - Other installations
     - [Install and run moodle](https://docs.moodle.org/402/en/Installing_Moodle)
     - copy / clone the code of the repository into the `repository/ocis` folder of your moodle installation
     - run `composer install` inside of the `repository/ocis` folder
3. Login to moodle as "admin"
4. If you run ocis on `localhost` or any local IP address go to the "HTTP security" page ("Site administration" > "Server" > "HTTP security") and delete the IP address and host-name you are using from the "cURL blocked hosts list" list
5. If you run ocis on any port other than `443` go to the "HTTP security" page ("Site administration" > "Server" > "HTTP security") and add the port you are using to the "cURL allowed ports list" list
6. Go to the "OAuth 2 services" page ("Site administration" > "Server" > "OAuth 2 services")
7. Create a new "Custom" service
   - Choose any name you like
     - Set "Client ID", for testing `xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69` can be used
     - Set "Client secret", for testing `UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh` can be used
     - Set "Service base URL" to the URL of your ocis instance. An instance with a trusted TLS certificate is required. 
     - Set "Scopes included in a login request for offline access." to `openid offline_access email profile`
8. Go to the "Manage repositories" page ("Site administration" > "Plugins" > "Repositories" > "Manage repositories")
9. Set the "ownCloud Infinite Scale repository" to "Enabled and visible"
10. Save the settings
11. Go again into the Settings page of the "ownCloud Infinite Scale repository"
12. Create a new repository instance
13. Choose a name you like
14. Select the Oauth2 service you created before
15. Save the settings
16. Navigate to any page where there is a file picker e.g. "My courses" > "Create course" > "Course image"
17. "Add" a new file
18. Select the repository you have created earlier
19. Click "Login in to your account"
20. Go through the login / oauth process
21. Now you should be able to see the content of your personal space and select files from there

