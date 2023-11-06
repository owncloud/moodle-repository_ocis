Feature: list the resources
  As a user
  I want to list the resources
  So that I can upload them to moodle

  Scenario: See the list
    Given a user has logged in
    And the user has navigated to add a new course page
    When the user clicks file-picker
    And the user selects Owncloud from the sidebar menu
    Then the file list from owncloud should be seen on the webUI