<?php
namespace Priblo\LaravelHasSettings\Repositories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Priblo\LaravelHasSettings\Models\HasSetting;
use Priblo\LaravelHasSettings\Repositories\Interfaces\HasSettingRepositoryInterface;

/**
 * Class EloquentHasSettingRepository
 * @package Priblo\LaravelHasSettings\Repositories
 */
class EloquentHasSettingRepository implements HasSettingRepositoryInterface {

    private $HasSetting;

    /**
     * EloquentHasSettingRepository constructor.
     * @param HasSetting $HasSetting
     */
    public function __construct(HasSetting $HasSetting)
    {
        $this->HasSetting = $HasSetting;
    }

    /**
     * @param Model $Model
     * @return Collection
     */
    public function findAllByModel(Model $Model)
    {
        return $this->HasSetting
            ->OfForeign($Model)
            ->get();
    }

    /**
     * @param Model $Model
     * @param $key
     * @return HasSetting
     */
    public function findOneByModelAndKey(Model $Model, $key)
    {
        return $this->HasSetting
            ->OfForeign($Model)
            ->where(['key'=>$key])
            ->first();
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return HasSetting
     */
    public function updateOneByModelAndKey(Model $Model, $key, $value)
    {
        return $this->HasSetting
            ->OfForeign($Model)
            ->where(['key'=>$key])
            ->update(['value' => $value]);
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return HasSetting
     */
    public function createOne(Model $Model, $key, $value)
    {
        $HasSetting = new $this->HasSetting;
        $HasSetting->foreign_id = $Model->getKey();
        $HasSetting->foreign_model = get_class($Model);
        $HasSetting->key = $key;
        $HasSetting->value = $value;
        $HasSetting->save();

        return $HasSetting;
    }
}