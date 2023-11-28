Description of updating ocis-php-sdk and its own requirements.

1. Install composer.
2. Set the desired version of `ocis-php-sdk` in `composer.json`.
3. Run `composer update --no-dev`.
4. Check the libraries are not already shipped by core. (Site Administration > Development > Third party libraries)
   If a library is already shipped by core, add it to the `replace` section of `composer.json` and return to step 3.
5. Update the version numbers of updated libraries in `thirdpartylibs.xml`.
6. Update `CHANGES.md`
7. Commit all changed files and folders and create an PR in https://github.com/owncloud/moodle-repository_ocis.
