<?php
namespace Priblo\LaravelHasAttributes\Repositories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Priblo\LaravelHasAttributes\Models\HasAttribute;
use Priblo\LaravelHasAttributes\Repositories\Interfaces\HasAttributeRepositoryInterface;

/**
 * Class EloquentHasAttributeRepository
 * @package Priblo\LaravelHasAttributes\Repositories
 */
class EloquentHasAttributeRepository implements HasAttributeRepositoryInterface {

    private $HasAttribute;

    /**
     * EloquentHasAttributeRepository constructor.
     * @param HasAttribute $HasAttribute
     */
    public function __construct(HasAttribute $HasAttribute)
    {
        $this->HasAttribute = $HasAttribute;
    }

    /**
     * @param Model $Model
     * @return string
     */
    public function findAllByModelAsJson(Model $Model)
    {
        $key_value = new \stdClass();

        $userAttributes = $this->findAllByModel($Model);
        foreach($userAttributes as $UserAttribute) {
            $value = $UserAttribute->value;
            $key = $UserAttribute->key;

            $key_value->$key = $value;
        }

        return json_encode($key_value);
    }

    /**
     * @param Model $Model
     * @return Collection
     */
    public function findAllByModel(Model $Model)
    {
        return $this->HasAttribute
            ->OfForeign($Model)
            ->get();
    }

    /**
     * @param Model $Model
     * @param $key
     * @return HasAttribute
     */
    public function findOneByModelAndKey(Model $Model, $key)
    {
        return $this->HasAttribute
            ->OfForeign($Model)
            ->where(['key'=>$key])
            ->first();
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return HasAttribute
     */
    public function updateOneByModelAndKey(Model $Model, $key, $value)
    {
        return $this->HasAttribute
            ->OfForeign($Model)
            ->where(['key'=>$key])
            ->update(['value' => $value]);
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return HasAttribute
     */
    public function createOneForModel(Model $Model, $key, $value)
    {
        $HasAttribute = new $this->HasAttribute;
        $HasAttribute->foreign_id = $Model->getKey();
        $HasAttribute->foreign_type = get_class($Model);
        $HasAttribute->key = $key;
        $HasAttribute->value = $value;
        $HasAttribute->save();

        return $HasAttribute;
    }

    /**
     * @param Model $Model
     * @param $key
     * @return null
     */
    public function deleteOneByModelAndKey(Model $Model, $key)
    {
        $this->HasAttribute
            ->OfForeign($Model)
            ->where(['key'=>$key])
            ->delete();

        return null;
    }

    /**
     * @param Model $Model
     * @return null
     */
    public function deleteAllByModel(Model $Model)
    {
        $this->HasAttribute
            ->OfForeign($Model)
            ->delete();

        return null;
    }

}