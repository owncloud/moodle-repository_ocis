@ocis @_file_upload @core @core_contentbank @core_h5p @contentbank_h5p @javascript @core_backup @contenttype_h5p
Feature: list the resources
  As a user
  I want to list the resources
  So that I can upload them to moodle

  Scenario: See the list
    Given I log in as "admin"
    And I am on site homepage
    And I am on "Acceptance test site" course homepage
    And I click on "More" "link" in the "(//li[@data-region='morebutton'])[2]" "xpath_element"
    And I click on "Content bank" "link"
    And I click on "Upload" "link"
    And I click on "Choose a file..." "button"
    And I click on "oCIS" "link" in the "File picker" "dialogue"
    And I click on "Log in to your account" "button"