<?php
/**
 * Drive
 *
 * PHP version 8.1
 *
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Libre Graph API
 *
 * Libre Graph is a free API for cloud collaboration inspired by the MS Graph API.
 *
 * The version of the OpenAPI document: v1.0.4
 * @generated Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 7.2.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Model;

use ArrayAccess;
use JsonSerializable;
use InvalidArgumentException;
use ReturnTypeWillChange;
use OpenAPI\Client\ObjectSerializer;

/**
 * Drive Class Doc Comment
 *
 * @description The drive represents a space on the storage.
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements ArrayAccess<string, mixed>
 */
class Drive implements ModelInterface, ArrayAccess, JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static string $openAPIModelName = 'drive';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var array<string, string>
      */
    protected static array $openAPITypes = [
        'id' => 'string',
        'created_by' => '\OpenAPI\Client\Model\IdentitySet',
        'created_date_time' => '\DateTime',
        'description' => 'string',
        'e_tag' => 'string',
        'last_modified_by' => '\OpenAPI\Client\Model\IdentitySet',
        'last_modified_date_time' => '\DateTime',
        'name' => 'string',
        'parent_reference' => '\OpenAPI\Client\Model\ItemReference',
        'web_url' => 'string',
        'drive_type' => 'string',
        'drive_alias' => 'string',
        'owner' => '\OpenAPI\Client\Model\IdentitySet',
        'quota' => '\OpenAPI\Client\Model\Quota',
        'items' => '\OpenAPI\Client\Model\DriveItem[]',
        'root' => '\OpenAPI\Client\Model\DriveItem',
        'special' => '\OpenAPI\Client\Model\DriveItem[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var array<string, string|null>
      */
    protected static array $openAPIFormats = [
        'id' => null,
        'created_by' => null,
        'created_date_time' => 'date-time',
        'description' => null,
        'e_tag' => null,
        'last_modified_by' => null,
        'last_modified_date_time' => 'date-time',
        'name' => null,
        'parent_reference' => null,
        'web_url' => null,
        'drive_type' => null,
        'drive_alias' => null,
        'owner' => null,
        'quota' => null,
        'items' => null,
        'root' => null,
        'special' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var array<string, bool>
      */
    protected static array $openAPINullables = [
        'id' => false,
		'created_by' => false,
		'created_date_time' => false,
		'description' => false,
		'e_tag' => false,
		'last_modified_by' => false,
		'last_modified_date_time' => false,
		'name' => false,
		'parent_reference' => false,
		'web_url' => false,
		'drive_type' => false,
		'drive_alias' => false,
		'owner' => false,
		'quota' => false,
		'items' => false,
		'root' => false,
		'special' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var array<string, bool>
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array<string, string>
     */
    public static function openAPITypes(): array
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array<string, string>
     */
    public static function openAPIFormats(): array
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array<string, bool>
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return array<string, bool>
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param array<string, bool> $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var array<string, string>
     */
    protected static array $attributeMap = [
        'id' => 'id',
        'created_by' => 'createdBy',
        'created_date_time' => 'createdDateTime',
        'description' => 'description',
        'e_tag' => 'eTag',
        'last_modified_by' => 'lastModifiedBy',
        'last_modified_date_time' => 'lastModifiedDateTime',
        'name' => 'name',
        'parent_reference' => 'parentReference',
        'web_url' => 'webUrl',
        'drive_type' => 'driveType',
        'drive_alias' => 'driveAlias',
        'owner' => 'owner',
        'quota' => 'quota',
        'items' => 'items',
        'root' => 'root',
        'special' => 'special'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var array<string, string>
     */
    protected static array $setters = [
        'id' => 'setId',
        'created_by' => 'setCreatedBy',
        'created_date_time' => 'setCreatedDateTime',
        'description' => 'setDescription',
        'e_tag' => 'setETag',
        'last_modified_by' => 'setLastModifiedBy',
        'last_modified_date_time' => 'setLastModifiedDateTime',
        'name' => 'setName',
        'parent_reference' => 'setParentReference',
        'web_url' => 'setWebUrl',
        'drive_type' => 'setDriveType',
        'drive_alias' => 'setDriveAlias',
        'owner' => 'setOwner',
        'quota' => 'setQuota',
        'items' => 'setItems',
        'root' => 'setRoot',
        'special' => 'setSpecial'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var array<string, string>
     */
    protected static array $getters = [
        'id' => 'getId',
        'created_by' => 'getCreatedBy',
        'created_date_time' => 'getCreatedDateTime',
        'description' => 'getDescription',
        'e_tag' => 'getETag',
        'last_modified_by' => 'getLastModifiedBy',
        'last_modified_date_time' => 'getLastModifiedDateTime',
        'name' => 'getName',
        'parent_reference' => 'getParentReference',
        'web_url' => 'getWebUrl',
        'drive_type' => 'getDriveType',
        'drive_alias' => 'getDriveAlias',
        'owner' => 'getOwner',
        'quota' => 'getQuota',
        'items' => 'getItems',
        'root' => 'getRoot',
        'special' => 'getSpecial'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array<string, string>
     */
    public static function attributeMap(): array
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array<string, string>
     */
    public static function setters(): array
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array<string, string>
     */
    public static function getters(): array
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName(): string
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var array
     */
    protected array $container = [];

    /**
     * Constructor
     *
     * @param array $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('id', $data ?? [], null);
        $this->setIfExists('created_by', $data ?? [], null);
        $this->setIfExists('created_date_time', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('e_tag', $data ?? [], null);
        $this->setIfExists('last_modified_by', $data ?? [], null);
        $this->setIfExists('last_modified_date_time', $data ?? [], null);
        $this->setIfExists('name', $data ?? [], null);
        $this->setIfExists('parent_reference', $data ?? [], null);
        $this->setIfExists('web_url', $data ?? [], null);
        $this->setIfExists('drive_type', $data ?? [], null);
        $this->setIfExists('drive_alias', $data ?? [], null);
        $this->setIfExists('owner', $data ?? [], null);
        $this->setIfExists('quota', $data ?? [], null);
        $this->setIfExists('items', $data ?? [], null);
        $this->setIfExists('root', $data ?? [], null);
        $this->setIfExists('special', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, mixed $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return string[] invalid properties with reasons
     */
    public function listInvalidProperties(): array
    {
        $invalidProperties = [];

        if (!is_null($this->container['created_date_time']) && !preg_match("/^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/", $this->container['created_date_time'])) {
            $invalidProperties[] = "invalid value for 'created_date_time', must be conform to the pattern /^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/.";
        }

        if (!is_null($this->container['last_modified_date_time']) && !preg_match("/^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/", $this->container['last_modified_date_time'])) {
            $invalidProperties[] = "invalid value for 'last_modified_date_time', must be conform to the pattern /^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/.";
        }

        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid(): bool
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string|null $id The unique idenfier for this drive.
     *
     * @return $this
     */
    public function setId(?string $id): static
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('non-nullable id cannot be null');
        }
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets created_by
     *
     * @return \OpenAPI\Client\Model\IdentitySet|null
     */
    public function getCreatedBy(): ?\OpenAPI\Client\Model\IdentitySet
    {
        return $this->container['created_by'];
    }

    /**
     * Sets created_by
     *
     * @param \OpenAPI\Client\Model\IdentitySet|null $created_by created_by
     *
     * @return $this
     */
    public function setCreatedBy(?\OpenAPI\Client\Model\IdentitySet $created_by): static
    {
        if (is_null($created_by)) {
            throw new InvalidArgumentException('non-nullable created_by cannot be null');
        }
        $this->container['created_by'] = $created_by;

        return $this;
    }

    /**
     * Gets created_date_time
     *
     * @return \DateTime|null
     */
    public function getCreatedDateTime(): ?\DateTime
    {
        return $this->container['created_date_time'];
    }

    /**
     * Sets created_date_time
     *
     * @param \DateTime|null $created_date_time Date and time of item creation. Read-only.
     *
     * @return $this
     */
    public function setCreatedDateTime(?\DateTime $created_date_time): static
    {
        if (is_null($created_date_time)) {
            throw new InvalidArgumentException('non-nullable created_date_time cannot be null');
        }

        if ((!preg_match("/^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/", ObjectSerializer::toString($created_date_time)))) {
            throw new InvalidArgumentException("invalid value for \$created_date_time when calling Drive., must conform to the pattern /^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/.");
        }

        $this->container['created_date_time'] = $created_date_time;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description Provides a user-visible description of the item. Optional.
     *
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        if (is_null($description)) {
            throw new InvalidArgumentException('non-nullable description cannot be null');
        }
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets e_tag
     *
     * @return string|null
     */
    public function getETag(): ?string
    {
        return $this->container['e_tag'];
    }

    /**
     * Sets e_tag
     *
     * @param string|null $e_tag ETag for the item. Read-only.
     *
     * @return $this
     */
    public function setETag(?string $e_tag): static
    {
        if (is_null($e_tag)) {
            throw new InvalidArgumentException('non-nullable e_tag cannot be null');
        }
        $this->container['e_tag'] = $e_tag;

        return $this;
    }

    /**
     * Gets last_modified_by
     *
     * @return \OpenAPI\Client\Model\IdentitySet|null
     */
    public function getLastModifiedBy(): ?\OpenAPI\Client\Model\IdentitySet
    {
        return $this->container['last_modified_by'];
    }

    /**
     * Sets last_modified_by
     *
     * @param \OpenAPI\Client\Model\IdentitySet|null $last_modified_by last_modified_by
     *
     * @return $this
     */
    public function setLastModifiedBy(?\OpenAPI\Client\Model\IdentitySet $last_modified_by): static
    {
        if (is_null($last_modified_by)) {
            throw new InvalidArgumentException('non-nullable last_modified_by cannot be null');
        }
        $this->container['last_modified_by'] = $last_modified_by;

        return $this;
    }

    /**
     * Gets last_modified_date_time
     *
     * @return \DateTime|null
     */
    public function getLastModifiedDateTime(): ?\DateTime
    {
        return $this->container['last_modified_date_time'];
    }

    /**
     * Sets last_modified_date_time
     *
     * @param \DateTime|null $last_modified_date_time Date and time the item was last modified. Read-only.
     *
     * @return $this
     */
    public function setLastModifiedDateTime(?\DateTime $last_modified_date_time): static
    {
        if (is_null($last_modified_date_time)) {
            throw new InvalidArgumentException('non-nullable last_modified_date_time cannot be null');
        }

        if ((!preg_match("/^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/", ObjectSerializer::toString($last_modified_date_time)))) {
            throw new InvalidArgumentException("invalid value for \$last_modified_date_time when calling Drive., must conform to the pattern /^[0-9]{4,}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]([.][0-9]{1,12})?([Zz]|[+-][0-9][0-9]:[0-9][0-9])$/.");
        }

        $this->container['last_modified_date_time'] = $last_modified_date_time;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name The name of the item. Read-write.
     *
     * @return $this
     */
    public function setName(string $name): static
    {
        if (is_null($name)) {
            throw new InvalidArgumentException('non-nullable name cannot be null');
        }
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets parent_reference
     *
     * @return \OpenAPI\Client\Model\ItemReference|null
     */
    public function getParentReference(): ?\OpenAPI\Client\Model\ItemReference
    {
        return $this->container['parent_reference'];
    }

    /**
     * Sets parent_reference
     *
     * @param \OpenAPI\Client\Model\ItemReference|null $parent_reference parent_reference
     *
     * @return $this
     */
    public function setParentReference(?\OpenAPI\Client\Model\ItemReference $parent_reference): static
    {
        if (is_null($parent_reference)) {
            throw new InvalidArgumentException('non-nullable parent_reference cannot be null');
        }
        $this->container['parent_reference'] = $parent_reference;

        return $this;
    }

    /**
     * Gets web_url
     *
     * @return string|null
     */
    public function getWebUrl(): ?string
    {
        return $this->container['web_url'];
    }

    /**
     * Sets web_url
     *
     * @param string|null $web_url URL that displays the resource in the browser. Read-only.
     *
     * @return $this
     */
    public function setWebUrl(?string $web_url): static
    {
        if (is_null($web_url)) {
            throw new InvalidArgumentException('non-nullable web_url cannot be null');
        }
        $this->container['web_url'] = $web_url;

        return $this;
    }

    /**
     * Gets drive_type
     *
     * @return string|null
     */
    public function getDriveType(): ?string
    {
        return $this->container['drive_type'];
    }

    /**
     * Sets drive_type
     *
     * @param string|null $drive_type Describes the type of drive represented by this resource. Values are \"personal\" for users home spaces, \"project\", \"virtual\" or \"share\". Read-only.
     *
     * @return $this
     */
    public function setDriveType(?string $drive_type): static
    {
        if (is_null($drive_type)) {
            throw new InvalidArgumentException('non-nullable drive_type cannot be null');
        }
        $this->container['drive_type'] = $drive_type;

        return $this;
    }

    /**
     * Gets drive_alias
     *
     * @return string|null
     */
    public function getDriveAlias(): ?string
    {
        return $this->container['drive_alias'];
    }

    /**
     * Sets drive_alias
     *
     * @param string|null $drive_alias The drive alias can be used in clients to make the urls user friendly. Example: 'personal/einstein'. This will be used to resolve to the correct driveID.
     *
     * @return $this
     */
    public function setDriveAlias(?string $drive_alias): static
    {
        if (is_null($drive_alias)) {
            throw new InvalidArgumentException('non-nullable drive_alias cannot be null');
        }
        $this->container['drive_alias'] = $drive_alias;

        return $this;
    }

    /**
     * Gets owner
     *
     * @return \OpenAPI\Client\Model\IdentitySet|null
     */
    public function getOwner(): ?\OpenAPI\Client\Model\IdentitySet
    {
        return $this->container['owner'];
    }

    /**
     * Sets owner
     *
     * @param \OpenAPI\Client\Model\IdentitySet|null $owner owner
     *
     * @return $this
     */
    public function setOwner(?\OpenAPI\Client\Model\IdentitySet $owner): static
    {
        if (is_null($owner)) {
            throw new InvalidArgumentException('non-nullable owner cannot be null');
        }
        $this->container['owner'] = $owner;

        return $this;
    }

    /**
     * Gets quota
     *
     * @return \OpenAPI\Client\Model\Quota|null
     */
    public function getQuota(): ?\OpenAPI\Client\Model\Quota
    {
        return $this->container['quota'];
    }

    /**
     * Sets quota
     *
     * @param \OpenAPI\Client\Model\Quota|null $quota quota
     *
     * @return $this
     */
    public function setQuota(?\OpenAPI\Client\Model\Quota $quota): static
    {
        if (is_null($quota)) {
            throw new InvalidArgumentException('non-nullable quota cannot be null');
        }
        $this->container['quota'] = $quota;

        return $this;
    }

    /**
     * Gets items
     *
     * @return \OpenAPI\Client\Model\DriveItem[]|null
     */
    public function getItems(): ?array
    {
        return $this->container['items'];
    }

    /**
     * Sets items
     *
     * @param \OpenAPI\Client\Model\DriveItem[]|null $items All items contained in the drive. Read-only. Nullable.
     *
     * @return $this
     */
    public function setItems(?array $items): static
    {
        if (is_null($items)) {
            throw new InvalidArgumentException('non-nullable items cannot be null');
        }
        $this->container['items'] = $items;

        return $this;
    }

    /**
     * Gets root
     *
     * @return \OpenAPI\Client\Model\DriveItem|null
     */
    public function getRoot(): ?\OpenAPI\Client\Model\DriveItem
    {
        return $this->container['root'];
    }

    /**
     * Sets root
     *
     * @param \OpenAPI\Client\Model\DriveItem|null $root root
     *
     * @return $this
     */
    public function setRoot(?\OpenAPI\Client\Model\DriveItem $root): static
    {
        if (is_null($root)) {
            throw new InvalidArgumentException('non-nullable root cannot be null');
        }
        $this->container['root'] = $root;

        return $this;
    }

    /**
     * Gets special
     *
     * @return \OpenAPI\Client\Model\DriveItem[]|null
     */
    public function getSpecial(): ?array
    {
        return $this->container['special'];
    }

    /**
     * Sets special
     *
     * @param \OpenAPI\Client\Model\DriveItem[]|null $special A collection of special drive resources.
     *
     * @return $this
     */
    public function setSpecial(?array $special): static
    {
        if (is_null($special)) {
            throw new InvalidArgumentException('non-nullable special cannot be null');
        }
        $this->container['special'] = $special;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[ReturnTypeWillChange]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[ReturnTypeWillChange]
    public function jsonSerialize(): mixed
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue(): string
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


