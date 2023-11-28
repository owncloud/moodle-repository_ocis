<?php

namespace Owncloud\OcisPhpSdk;

use  OpenAPI\Client\Model\User as OpenAPIUser;
use Owncloud\OcisPhpSdk\Exception\InvalidResponseException;

class User
{
    private string $id;
    private string $displayName;
    private string $mail;
    private string $onPremisesSamAccountName;
    /**
     * @param OpenAPIUser $openApiUser
     */
    public function __construct(
        OpenAPIUser $openApiUser
    ) {
        $this->id = empty($openApiUser->getId()) ?
        throw new InvalidResponseException(
            "Invalid id returned for user '" . print_r($openApiUser->getid(), true) . "'"
        )
        : $openApiUser->getId();
        $this->displayName = empty($openApiUser->getDisplayName()) ?
        throw new InvalidResponseException(
            "Invalid displayName returned for user '" . print_r($openApiUser->getDisplayName(), true) . "'"
        )
        : $openApiUser->getDisplayName();
        $this->mail = empty($openApiUser->getMail()) ?
        throw new InvalidResponseException(
            "Invalid mail returned for user '" . print_r($openApiUser->getMail(), true) . "'"
        )
        : $openApiUser->getMail();
        $this->onPremisesSamAccountName = empty($openApiUser->getOnPremisesSamAccountName()) ?
        throw new InvalidResponseException("Invalid onPremisesSamAccountName returned for user '" .
            print_r($openApiUser->getOnPremisesSamAccountName(), true) . "'")
        : $openApiUser->getOnPremisesSamAccountName();
    }

    /**
     * Get the value of displayName
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * Get the value of onPremisesSamAccountName
     */
    public function getOnPremisesSamAccountName(): string
    {
        return $this->onPremisesSamAccountName;
    }
}
