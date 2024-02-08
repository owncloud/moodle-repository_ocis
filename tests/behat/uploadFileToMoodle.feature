@ocis @javascript
Feature: upload the resource in oCIS to moodle
  As a user who manages moodle content
  I want to make resources from oCIS available in moodle
  So that the resource content can be integrated into moodle course content


  Background:
    Given I log in as "admin"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I log in to ocis as "admin"
    And "admin" has created a file "new.txt" in "Personal" space


  Scenario: upload a file from the personal drive of ocis to moodle
    When I click on "//*[@class='fp-filename-field']/p[text()='Personal']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='new.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "new.txt"