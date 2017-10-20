<?php
namespace Priblo\LaravelHasSettings\Traits;

use Priblo\LaravelHasSettings\Models\HasSetting as HasSettingModel;
use Priblo\LaravelHasSettings\Repositories\Interfaces\HasSettingRepositoryInterface;

/**
 * Trait HasSettings
 * @package Priblo\LaravelHasSettings\Traits
 */
trait HasSettings
{
    /**
     * @var HasSettingRepositoryInterface
     */
    private $Decorated = null;

    /**
     * HasSettings constructor.
     */
    public function __construct()
    {
        $this->Decorated = resolve(HasSettingRepositoryInterface::class);
    }

    /**
     * Quick shortcut to create or update a setting
     *
     * @param $key
     * @param $value
     * @return HasSettingModel
     */
    public function createOrUpdateSetting($key, $value)
    {
        if ($this->hasSetting($key)) {
            return $this->updateOneSetting($key, $value);
        }

        return $this->createOneSetting($key, $value);
    }

    /**
     * Read all Settings as a key/value object
     *
     * @return \stdClass
     */
    public function readAllSettings()
    {
        return json_decode($this->Decorated->findAllByModelAsJson($this));
    }

    /**
     * Check if user has a specific setting
     *
     * @param $key
     * @return bool
     */
    public function hasSetting($key)
    {
        return (!is_null($this->readOneSetting($key)));
    }

    /**
     * Create one setting
     *
     * @param $key
     * @return HasSettingModel
     */
    public function createOneSetting($key, $value)
    {
        return $this->Decorated->createOneForModel($this, $key, $value);
    }

    /**
     * Read one setting
     *
     * @param $key
     * @return string|null
     */
    public function readOneSetting($key)
    {
        $HasSetting = $this->Decorated->findOneByModelAndKey($this, $key);
        if(is_null($HasSetting)) {
            return null;
        }
        return $HasSetting->value;
    }

    /**
     * Updates one setting
     *
     * @param $key
     * @param $new_value
     * @return HasSettingModel
     */
    public function updateOneSetting($key, $new_value)
    {
        return $this->Decorated->updateOneByModelAndKey($this, $key, $new_value);
    }

    /**
     * Deletes one key
     *
     * @param $key
     * @return null
     */
    public function deleteOneSetting($key)
    {
        if($this->hasSetting($key)) {
            $this->Decorated->deleteOneByModelAndKey($this, $key);
        }
        return null;
    }

    /**
     * Deletes all settings attached to a model
     *
     * @return null
     */
    public function deleteAllSettings()
    {
        return $this->Decorated->deleteAllByModel($this);
    }
}