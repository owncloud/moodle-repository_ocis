@ocis @javascript @repository_ocis @repository
Feature: changing settings of oCIS plugin
  As a user who manages moodle content
  I want to restrict users access to a drive
  So that the users can only access what is necessary for them

  Background:
    Given I log in as "admin"
    And "admin" has created the project space "ProjectMoodle"
    And user "admin" has uploaded a file inside space "ProjectMoodle" with content "some content" to "/testfile.txt"
    And I navigate to "Plugins > Repositories > ownCloud Infinite Scale repository" in site administration
    And I click on "Settings" "link"

  Scenario Outline: hide personal/shares drive
    When I change the visibility of "<hiddenDrive>" drive to "No"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I log in to ocis as "admin"
    Then I should not see "<hiddenDrive>"
    And I should see "<visibleDrive>"
    And I should see "<visibleDrive1>"
    Examples:
      | hiddenDrive | visibleDrive | visibleDrive1 |
      | Shares      | Personal     | ProjectMoodle |
      | Personal    | Shares       | ProjectMoodle |
      | Project     | Personal     | Shares        |

  Scenario: change image of drives
    When I set the following fields to these values:
      | Icon URL for personal drive | image.png  |
      | Icon URL for shares         | image1.png |
      | Icon URL for project drive  | image2.png |
    And I click on "Save" "button"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I log in to ocis as "admin"
    Then the "src" attribute of "//img[@title='Personal']" "xpath_element" should contain "image.png"
    And the "src" attribute of "//img[@title='Shares']" "xpath_element" should contain "image1.png"
    And the "src" attribute of "//img[@title='ProjectMoodle']" "xpath_element" should contain "image2.png"
