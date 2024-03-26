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


  Scenario: upload a file from the personal drive of ocis to moodle
    And user "admin" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    When I click on "//*[@class='fp-filename-field']/p[text()='Personal']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='testfile.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "testfile.txt"


  Scenario: upload a file from project space of ocis to moodle
    Given "admin" has created the project space "ProjectMoodle"
    And user "admin" has uploaded a file inside space "ProjectMoodle" with content "some content" to "/testfile.txt"
    And I refresh the file-picker
    When I click on "//*[@class='fp-filename-field']/p[text()='ProjectMoodle']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='testfile.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "testfile.txt"


  Scenario: upload a file from share space of ocis to moodle
    Given user "Brian" has been created with default attributes
    And user "Brian" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    And user "Brian" has sent the following share invitation:
      | resource        | testfile.txt |
      | space           | Personal     |
      | sharee          | Admin        |
      | shareType       | user         |
      | permissionsRole | Viewer       |
    And I wait "1" seconds
    When I click on "//*[@class='fp-filename-field']/p[text()='Shares']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='testfile.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "testfile.txt"

