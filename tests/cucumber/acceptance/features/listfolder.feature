Feature: todo
  As a user
  I want to list the resources
  So that I can add courses

  Scenario: See the list
    Given a user has logged in
    And a user has navigated to my course page
    When the user clicks file-picker
    And the user chooses own-cloud
    Then files should be listed on the webUI