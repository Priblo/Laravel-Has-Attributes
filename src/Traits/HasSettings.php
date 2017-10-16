<?php
namespace Priblo\LaravelHasSettings\Traits;

use Priblo\LaravelHasSettings\Models\HasSetting;
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
     * @return HasSettings
     */
    public function createOrUpdateSetting($key, $value)
    {
        if ($this->hasSetting($key)) {
            return $this->updateOneSetting($key, $value);
        } else {
            return $this->createOneSetting($key, $value);
        }
    }

    /**
     * Read all Settings as a key/value object
     *
     * @return \stdClass
     */
    public function readAllSettings()
    {
        $key_value = new \stdClass();

        $userSettings = $this->Decorated->findAllByModel($this);
        foreach($userSettings as $UserSetting) {
            $value = $UserSetting->value;
            $key = $UserSetting->key;

            $key_value->$key = $value;
        }
        return $key_value;
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
     * @return HasSetting
     */
    public function createOneSetting($key, $value)
    {
        return $this->Decorated->createOne($this, $key, $value);
    }

    /**
     * Read one setting
     *
     * @param $key
     * @return HasSetting
     */
    public function readOneSetting($key)
    {
        return $this->Decorated->findOneByModelAndKey($this, $key);
    }

    /**
     * Updates one setting
     *
     * @param $key
     * @param $new_value
     * @return HasSetting
     */
    public function updateOneSetting($key, $new_value)
    {
        return $this->Decorated->updateOneByModelAndKey($this, $key, $new_value);
    }

}