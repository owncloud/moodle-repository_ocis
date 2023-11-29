Feature: list the resources
 As a user
  I want to list the resources
  So that I can upload them to moodle

  Scenario: See the list
    Given administrator has created the following folders in oCIS server
      | Test       |
      | New Folder |
      | Test2      |
    And a user has logged into moodle
    And the user has navigated to add a new course page
    When the user opens file-picker
    And the user selects the repository owncloud
    Then the following folder should be listed on the webUI
      | Test       |
      | New Folder |
      | Test2      |
