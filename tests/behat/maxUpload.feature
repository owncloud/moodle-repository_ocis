@max_uploas @javascript @repository_ocis @repository

Feature: try to upload the resource in moodle from oCIS with maxupload setting
  As a user who manages moodle content
  I want to limit file upload size
  So that the storage won't be full

  Scenario: upload file that exceeds moodle upload limit
    Given user "Admin" has uploaded file "fileForUpload/testavatar.jpg" to "testavatar.jpg"
    And I log in as "admin"
    And I am on site homepage
    And I navigate to "General > Security > Site security settings" in site administration
    And I click on "//*[@id='id_s__maxbytes']/option[10]" "xpath_element"
    And I press "Save changes"
    And I follow "Profile" in the user menu
    And I click on "Blog entries" "link"
    And I click on "Add a new entry" "link"
    And I click on "Add.." "button"
    And I click on "oCIS" "link"
    And I click on "Log in to your account" "button"
    And I switch to a second window
    And I log in to ocis as "admin"
    When I click on "//*[@class='fp-filename-field']/p[text()='Personal']" "xpath_element"
    And I click on "//*[@class='fp-filename-field']/p[text()='testavatar.jpg']" "xpath_element"
    And I click on "Select this file" "button"
    Then I should see error "File exceeds maximum uploaded file size limit"
