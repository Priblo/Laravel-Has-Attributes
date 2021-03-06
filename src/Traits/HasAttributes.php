<?php
namespace Priblo\LaravelHasAttributes\Traits;

use Priblo\LaravelHasAttributes\Models\HasAttribute as HasAttributeModel;
use Priblo\LaravelHasAttributes\Repositories\Interfaces\HasAttributeRepositoryInterface;

/**
 * Trait HasAttributes
 * @package Priblo\LaravelHasAttributes\Traits
 */
trait HasAttributes
{
    /**
     * @var HasAttributeRepositoryInterface
     */
    private $Decorated = null;

    /**
     * HasAttributes constructor.
     *
     * Has to call parent contructor to avoid issues with mass fillables
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->Decorated = resolve(HasAttributeRepositoryInterface::class);
    }

    /**
     * Quick shortcut to create or update a setting
     *
     * @param $key
     * @param $value
     * @return HasAttributeModel
     */
    public function createOrUpdateAttribute($key, $value)
    {
        if ($this->hasAttribute($key)) {
            return $this->updateOneAttribute($key, $value);
        }

        return $this->createOneAttribute($key, $value);
    }

    /**
     * Read all Attributes as a key/value object
     *
     * @return \stdClass
     */
    public function readAllAttributes()
    {
        return json_decode($this->Decorated->findAllByModelAsJson($this));
    }

    /**
     * Check if user has a specific Attribute
     *
     * @param $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return (!is_null($this->readOneAttribute($key)));
    }

    /**
     * Create one Attribute
     *
     * @param $key
     * @return HasAttributeModel
     */
    public function createOneAttribute($key, $value)
    {
        return $this->Decorated->createOneForModel($this, $key, $value);
    }

    /**
     * Read one Attribute
     *
     * @param $key
     * @param null $default
     * @return string|null
     */
    public function readOneAttribute($key, $default = null)
    {
        $HasAttribute = $this->Decorated->findOneByModelAndKey($this, $key);
        if(is_null($HasAttribute)) {
            return $default;
        }
        return $HasAttribute->value;
    }

    /**
     * Updates one Attribute
     *
     * @param $key
     * @param $new_value
     * @return HasAttributeModel
     */
    public function updateOneAttribute($key, $new_value)
    {
        return $this->Decorated->updateOneByModelAndKey($this, $key, $new_value);
    }

    /**
     * Deletes one key
     *
     * @param $key
     * @return null
     */
    public function deleteOneAttribute($key)
    {
        if($this->hasAttribute($key)) {
            $this->Decorated->deleteOneByModelAndKey($this, $key);
        }
        return null;
    }

    /**
     * Deletes all Attributes attached to a model
     *
     * @return null
     */
    public function deleteAllAttributes()
    {
        return $this->Decorated->deleteAllByModel($this);
    }
}
