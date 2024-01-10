@ocis @javascript
Feature: upload the resource in oCIS to moodle
  As a user
  I want to list the resources
  So that I can upload them to moodle
  

  Background:
    Given I log in as "admin"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I set the field with xpath "//*[@id='oc-login-username']" to "admin"
    And I set the field with xpath "//*[@id='oc-login-password']" to "admin"
    And I click on "Log in" "button"
    And I click on Allow Button


  Scenario: upload a file from the personal drive of ocis to moodle
    When I click on "//*[@class='fp-filename-field']/p[text()='Personal']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='new.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "new.txt"