@ocis @javascript
Feature: upload the resource in oCIS to moodle
  As a user who manages moodle content
  I want to restrict users access to a space
  So that the users can only access what is necessary for them

  Background:
    Given I log in as "admin"
    And I navigate to "Plugins > Repositories > ownCloud Infinite Scale repository" in site administration
    And I click on "Settings" "link" 
    
  
  Scenario: change image of drives
    And I set the following fields to these values:
      | Icon URL for Personal Drive | image.png |
    And I click on "Save" "button"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I log in to ocis as "admin"
    And I wait "55" seconds
    And the "src" attribute of "//img[@title='Personal']" "xpath_element" should contain "image.png" 