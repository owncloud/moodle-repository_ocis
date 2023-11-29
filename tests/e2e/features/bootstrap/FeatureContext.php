<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given administrator has created the following folders in oCIS server
     */
    public function createFolder(string $rseourceName)
    {
        var_dump($rseourceName);
        throw new \Exception();
    }

    /**
     * @Given a user has logged into moodle
     */
    public function logInToMoodel()
    {
        throw new \Exception();
    }

    /**
     * @Given the user has navigated to add a new course page
     */
    public function navigateCourcePage()
    {
        throw new \Exception();
    }

    /**
     * @When the user opens file-picker
     */
    public function openFilePicker()
    {
        throw new \Exception();
    }

    /**
     * @When the user selects the repository :owncloud
     */
    public function openrepository(string $repository)
    {
        var_dump($repository);
        throw new \Exception();
    }


    /**
     * @When the user selects the repository owncloud
     */
    public function theUserSelectsTheRepositoryOwncloud()
    {
        // Write code here that turns the phrase above into concrete actions
    }

    /**
     * @Given the following folder should be listed on the webUI
     */
    public function fileShouldExist(PyStringNode $rseourceName)
    {
        var_dump($rseourceName);

        throw new \Exception();
    }
}
