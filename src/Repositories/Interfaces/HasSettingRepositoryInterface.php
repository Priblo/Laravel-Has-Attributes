<?php
namespace Priblo\LaravelHasSettings\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface HasSettingRepositoryInterface
 * @package Priblo\LaravelHasSettings\Repositories\Interfaces
 */
interface HasSettingRepositoryInterface
{
    public function findAllByModelAsJson(Model $Model);

    public function findAllByModel(Model $Model);

    public function findOneByModelAndKey(Model $Model, $key);

    public function updateOneByModelAndKey(Model $Model, $key, $value);

    public function createOneForModel(Model $Model, $key, $value);

    public function deleteOneByModelAndKey(Model $Model, $key);

    public function deleteAllByModel(Model $Model);
}