<?php

namespace Owncloud\OcisPhpSdk;

use OpenAPI\Client\Model\DriveItem;
use OpenAPI\Client\Model\Identity;
use OpenAPI\Client\Model\ItemReference;
use OpenAPI\Client\Model\Permission;
use OpenAPI\Client\Model\RemoteItem;
use Owncloud\OcisPhpSdk\Exception\InvalidResponseException;
use Owncloud\OcisPhpSdk\Exception\TooEarlyException;

/**
 * Ensures that the return type is correct, but Phan does not recognize it.
 * @phan-file-suppress PhanTypeMismatchReturnNullable
 */
class ShareReceived
{
    private DriveItem $shareReceived;


    /**
     * @param DriveItem $shareReceived
     */
    public function __construct(
        DriveItem $shareReceived
    ) {
        $this->shareReceived = $shareReceived;
    }

    /**
     *
     * @return string
     * @throws TooEarlyException
     */
    public function getId(): string
    {
        return ($this->shareReceived->getId() === null)
            ? throw new TooEarlyException()
            : $this->shareReceived->getId();
    }

    /**
     * @return string
     * @throws InvalidResponseException
     */
    public function getName(): string
    {
        return empty($this->shareReceived->getName())
            ? throw new InvalidResponseException(
                "Invalid resource name '" . print_r($this->shareReceived->getName(), true) . "'"
            )
            : $this->shareReceived->getName();
    }

    /**
     * @return string
     * @throws TooEarlyException
     */
    public function getEtag(): string
    {
        return ($this->shareReceived->getETag() === null)
            ? throw new TooEarlyException()
            : $this->shareReceived->getETag();
    }

    /**
     * @throws InvalidResponseException
     */
    private function getParentReference(): ItemReference
    {
        return empty($this->shareReceived->getParentReference()) ?
            throw new TooEarlyException()
            : $this->shareReceived->getParentReference();

    }

    /**
     * @return string
     * @throws InvalidResponseException
     */
    public function getParentDriveId(): string
    {
        $parentReference = $this->getParentReference();
        return empty($parentReference->getDriveId()) ?
           throw new InvalidResponseException(
               "Invalid driveId returned in parentReference of received share '" .
               print_r($parentReference->getDriveId(), true) . "'"
           )
           : $parentReference->getDriveId();
    }

    /**
     * @throws InvalidResponseException
     */
    public function getParentDriveType(): DriveType
    {
        $driveTypeString = (string)$this->getParentReference()->getDriveType();
        $driveType = DriveType::tryFrom($driveTypeString);
        if ($driveType instanceof DriveType) {
            return $driveType;
        }
        throw new InvalidResponseException(
            'Invalid driveType returned in parentReference of received share: "' .
            print_r($driveTypeString, true) . '"'
        );
    }

    /**
     * @throws InvalidResponseException
     */
    private function getRemoteItem(): RemoteItem
    {
        return empty($this -> shareReceived -> getRemoteItem())
            ? throw new InvalidResponseException(
                "Invalid remote item '" . print_r($this -> shareReceived -> getParentReference(), true) . "'"
            ) : $this->shareReceived->getRemoteItem();
    }

    /**
     * @return string
     * @throws InvalidResponseException
     */
    public function getRemoteItemId(): string
    {
        $remoteItem = $this->getRemoteItem();
        return empty($remoteItem->getId())
            ? throw new InvalidResponseException(
                "Invalid remote item id '" . print_r($this->shareReceived->getRemoteItem(), true) . "'"
            )
            : $remoteItem->getId();
    }

    /**
     * @return string
     * @throws InvalidResponseException
     */
    public function getRemoteItemName(): string
    {
        $remoteItem = $this->getRemoteItem();
        return empty($remoteItem->getName())
            ? throw new InvalidResponseException(
                "Invalid remote item name '" . print_r($remoteItem, true) . "'"
            )
            : $remoteItem->getName();
    }

    /**
     * @return int
     * @throws InvalidResponseException
     */
    public function getRemoteItemSize(): int
    {
        $remoteItem = $this->getRemoteItem();
        return empty($remoteItem->getSize())
            ? throw new InvalidResponseException(
                "Invalid remote item size '" . print_r($remoteItem, true) . "'"
            )
            : $remoteItem->getSize();
    }

    /**
     * @throws InvalidResponseException
     */
    private function getShared(): \OpenAPI\Client\Model\Shared
    {
        $remoteItem = $this->getRemoteItem();

        return empty($remoteItem->getShared()) ?
            throw new InvalidResponseException(
                "Invalid shared '" . print_r($remoteItem, true) . "'"
            ) : $remoteItem->getShared();
    }

    /**
     * @return \DateTimeImmutable
     * @throws InvalidResponseException
     */
    public function getRemoteItemSharedDateTime(): \DateTimeImmutable
    {
        $sharedInfo = $this->getShared();
        $time = $sharedInfo->getSharedDateTime();
        if (empty($time)) {
            throw new InvalidResponseException(
                "Invalid shared DateTime'" . print_r($sharedInfo->getSharedDateTime(), true) . "'"
            );
        }
        return \DateTimeImmutable::createFromMutable($time);
    }

    /**
     * @throws InvalidResponseException
     */
    private function getOwnerUser(): Identity
    {
        return empty($this->getShared()->getOwner())
        || empty($this->getShared()->getOwner()->getUser()) ?
            throw new InvalidResponseException(
                "Invalid owner information '" . print_r($this->getShared()->getOwner(), true) . "'"
            ) : $this->getShared()->getOwner()->getUser();
    }

    /**
     * @throws InvalidResponseException
     */
    public function getOwnerName(): string
    {
        $ownerUser = $this->getOwnerUser();
        return empty($ownerUser->getDisplayName())
            ? throw new InvalidResponseException(
                "Invalid share owner name '" . print_r($ownerUser, true) . "'"
            )
            : $ownerUser->getDisplayName();
    }

    /**
     * @throws InvalidResponseException
     */
    public function getOwnerId(): string
    {
        $ownerUser = $this->getOwnerUser();
        return empty($ownerUser->getId()) ? throw new InvalidResponseException(
            "Invalid share owner id '" . print_r($ownerUser->getId(), true) . "'"
        ) : $ownerUser->getId();
    }

    /**
     * gets the first permissio of the remote item
     * in theory there might be more that one permission, but currently there is no such case in ocis
     * @return Permission
     * @throws InvalidResponseException
     */
    private function getRemoteItemPermission()
    {
        $remoteItem = $this->getRemoteItem();
        $permissions = $remoteItem->getPermissions();
        if ($permissions === null || sizeof($permissions) !== 1) {
            throw new InvalidResponseException('Invalid permissions in remoteItem');
        }
        return $permissions[0];
    }

    /**
     * @throws InvalidResponseException
     */
    public function isUiHidden(): bool
    {
        $uiHidden = $this->getRemoteItemPermission()->getAtUiHidden();
        if ($uiHidden === null) {
            throw new InvalidResponseException('Invalid "@ui.hidden" parameter in permission');
        }
        return $uiHidden;
    }

    /**
     * @throws InvalidResponseException
     */
    public function isClientSyncronize(): bool
    {
        $clientSyncronize = $this->getRemoteItemPermission()->getAtClientSynchronize();
        if ($clientSyncronize === null) {
            throw new InvalidResponseException('Invalid "@client.synchronize" parameter in permission');
        }
        return $clientSyncronize;
    }
}
