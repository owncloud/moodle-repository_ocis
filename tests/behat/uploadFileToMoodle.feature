@ocis @javascript @repository_ocis @repository
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
    Given user "admin" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
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
    When I click on "//*[@class='fp-filename-field']/p[text()='Shares']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='testfile.txt']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see "testfile.txt"

  Scenario: click refresh button to get latest resource on Personal drive
    Given I click on "Personal" "link"
    When user "admin" uploads a file inside space "Personal" with content "some content" to "testfile.txt"
    Then I should not see "testfile.txt"
    But I should see "testfile.txt" after refreshing the file-picker

  Scenario: click refresh button to get latest resource on Project drive
    When "admin" creates the project space "ProjectMoodle"
    Then I should not see "ProjectMoodle"
    But I should see "ProjectMoodle" after refreshing the file-picker
    When I click on "ProjectMoodle" "link"
    And user "admin" uploads a file inside space "ProjectMoodle" with content "some content" to "testfile.txt"
    Then I should not see "testfile.txt"
    But I should see "testfile.txt" after refreshing the file-picker

  Scenario: click refresh button to get latest resource of Share drive
    Given I click on "Shares" "link"
    And user "Brian" has been created with default attributes
    And user "Brian" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    When user "Brian" sends the following share invitation:
      | resource        | testfile.txt |
      | space           | Personal     |
      | sharee          | Admin        |
      | shareType       | user         |
    Then I should not see "testfile.txt"
    But I should see "testfile.txt" after refreshing the file-picker

  Scenario: navigate using links in file-picker from root to Personal drive and back
    Given user "admin" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    And I click on "Personal" "link"
    And I should see "testfile.txt"
    When I click on "oCIS" "link"
    Then I should see "Personal"
    And I should see "Shares"

  Scenario: navigate using links in file-picker from root to Project drive and back
    Given user "Brian" has been created with default attributes
    And user "Brian" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    And user "Brian" has sent the following share invitation:
      | resource        | testfile.txt |
      | space           | Personal     |
      | sharee          | Admin        |
      | shareType       | user         |
    And I click on "Shares" "link"
    And I should see "testfile.txt"
    When I click on "oCIS" "link"
    Then I should see "Personal"
    And I should see "Shares"

  Scenario: navigate using links in file-picker from root to Shares drive and back
    Given "admin" has created the project space "ProjectMoodle"
    And user "admin" has uploaded a file inside space "ProjectMoodle" with content "some content" to "/testfile.txt"
    And I refresh the file-picker
    And I click on "ProjectMoodle" "link"
    And I should see "testfile.txt"
    When I click on "oCIS" "link"
    Then I should see "Personal"
    And I should see "Shares"
    And I should see "ProjectMoodle"

  @skipOnStable @ocis-issue-8961
  Scenario: enable/disable sync of shared resource shared from Personal Space
    Given user "Brian" has been created with default attributes
    And user "Brian" has uploaded a file inside space "Personal" with content "some content" to "/testfile.txt"
    And user "Brian" has sent the following share invitation:
      | resource  | testfile.txt |
      | space     | Personal     |
      | sharee    | Admin        |
      | shareType | user         |
    When user "Admin" disables sync of share "testfile.txt"
    And I click on "//*[@class='fp-filename-field']/p[text()='Shares']" "xpath_element"
    Then I should not see "testfile.txt"
    When user "Admin" enables sync of share "testfile.txt" offered by "Brian" from "Personal" space
    And I refresh the file-picker
    Then I should see "testfile.txt"
