# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## Summary
* Bugfix - fixed a bug where a user could end up with an unusable file-picker [#83](https://github.com/owncloud/moodle-repository_ocis/pull/83)
* Bugfix - updated to ocis-php-sdk 1.0.0-rc2 & libre-graph-api-php dev-main c728b27

## Details

* Bugfix - fixed a bug where a user could end up with an unusable file-picker [#83](https://github.com/owncloud/moodle-repository_ocis/pull/83)
   We have fixed a bug where when a user, with a ocis-token, looses access to ocis, would only see an error message and could not use the file-picker nor could log-out.
   The solution was to log-out the user automatically in those cases.

   https://github.com/owncloud/moodle-repository_ocis/issues/80
   https://github.com/owncloud/moodle-repository_ocis/pull/83

* Bugfix - updated to ocis-php-sdk 1.0.0-rc2 & libre-graph-api-php dev-main c728b27 [#82](https://github.com/owncloud/moodle-repository_ocis/pull/82)
   We have updated to the newest versions of the dependencies that are adjusted to changes in oCIS

# Changelog for [1.0.0-rc.1] (2024-01-18)

## Summary

* Bugfix - fixed destination of manage button [#50](https://github.com/owncloud/moodle-repository_ocis/issues/50)
* Bugfix - made string for `Shares` translatable in the breadcrumbs [#66](https://github.com/owncloud/moodle-repository_ocis/issues/66)
* Bugfix - shares that are set to `hide` in ocis webUI are hidden also in moodle [#77](https://github.com/owncloud/moodle-repository_ocis/pull/77)
* Enhancement - default icons for the different drive-types are the same as in ocis-web [#76](https://github.com/owncloud/moodle-repository_ocis/pull/76)

## Details

# Changelog for [1.0.0-beta.2] (2024-01-02)

## Summary

* Bugfix - fixed version number in version.php [#59](https://github.com/owncloud/moodle-repository_ocis/pull/59)
* Change - delete extra line to be consistent with moodle codestyle [#65](https://github.com/owncloud/moodle-repository_ocis/pull/65)
* Change - improve PHPDocs to be consistent with moodle PHPdoc checker [#67](https://github.com/owncloud/moodle-repository_ocis/pull/67)

## Details
