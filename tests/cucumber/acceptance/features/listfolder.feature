Feature: todo
  As a user
  I want to list the resources
  So that I can add courses

  Scenario: See the list
    Given a user has uploaded these <"Folders"> and <"Files"> to the ownCloud
    |Folders|Files|

    And a user has logged in
    And the user has navigated to add a new course page
    When the user clicks file-picker
    And the user selects Owncloud from the sidebar menu
    Then these files should be seen on the webUI