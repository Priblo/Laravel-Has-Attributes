<?php
namespace Priblo\LaravelHasAttributes\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface HasAttributeRepositoryInterface
 * @package Priblo\LaravelHasAttributes\Repositories\Interfaces
 */
interface HasAttributeRepositoryInterface
{
    public function findAllByModelAsJson(Model $Model);

    public function findAllByModel(Model $Model);

    public function findOneByModelAndKey(Model $Model, $key);

    public function updateOneByModelAndKey(Model $Model, $key, $value);

    public function createOneForModel(Model $Model, $key, $value);

    public function deleteOneByModelAndKey(Model $Model, $key);

    public function deleteAllByModel(Model $Model);
}