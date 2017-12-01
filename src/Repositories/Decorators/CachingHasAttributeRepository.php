<?php
namespace Priblo\LaravelHasAttributes\Repositories\Decorators;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Model;
use Priblo\LaravelHasAttributes\Repositories\EloquentHasAttributeRepository;
use Priblo\LaravelHasAttributes\Repositories\Interfaces\HasAttributeRepositoryInterface;

class CachingHasAttributeRepository implements HasAttributeRepositoryInterface
{
    protected $repository;
    protected $cache;
    protected $cache_expiry;

    public function __construct(EloquentHasAttributeRepository $repository, Cache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
        $this->cache_expiry = config('has-settings.cache_expiry');
    }

    /**
     * @param Model $Model
     * @return mixed
     */
    public function findAllByModelAsJson(Model $Model)
    {
        return $this->cache->tags($this->makeCacheTag($Model))->remember('findAllByModelAsJson', $this->cache_expiry, function () use ($Model) {
            return $this->repository->findAllByModelAsJson($Model);
        });
    }

    /**
     * @param Model $Model
     * @return mixed
     */
    public function findAllByModel(Model $Model)
    {
        return $this->cache->tags($this->makeCacheTag($Model))->remember('findAllByModel', $this->cache_expiry, function () use ($Model) {
            return $this->repository->findAllByModel($Model);
        });
    }

    /**
     * Find one cannot be cached at the moment given that the cacheTag is related to the composite key Model/PK
     * TODO scope this cached entry to cache specific to the provided key
     *
     * @param Model $Model
     * @param $key
     * @return \Priblo\LaravelHasAttributes\Models\HasAttribute
     */
    public function findOneByModelAndKey(Model $Model, $key)
    {
        return $this->repository->findOneByModelAndKey($Model,$key);
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return \Priblo\LaravelHasAttributes\Models\HasAttribute
     */
    public function updateOneByModelAndKey(Model $Model, $key, $value)
    {
        $this->cache->tags($this->makeCacheTag($Model))->flush();
        return $this->repository->updateOneByModelAndKey($Model, $key, $value);
    }

    /**
     * @param Model $Model
     * @param $key
     * @param $value
     * @return \Priblo\LaravelHasAttributes\Models\HasAttribute
     */
    public function createOneForModel(Model $Model, $key, $value)
    {
        $this->cache->tags($this->makeCacheTag($Model))->flush();
        return $this->repository->createOneForModel($Model, $key, $value);
    }

    /**
     * @param Model $Model
     * @param $key
     * @return null
     */
    public function deleteOneByModelAndKey(Model $Model, $key)
    {
        $this->cache->tags($this->makeCacheTag($Model))->flush();
        return $this->repository->deleteOneByModelAndKey($Model, $key);
    }

    /**
     * @param Model $Model
     * @return null
     */
    public function deleteAllByModel(Model $Model)
    {
        $this->cache->tags($this->makeCacheTag($Model))->flush();
        return $this->repository->deleteAllByModel($Model);
    }

    /**
     * @param Model $Model
     * @return string
     */
    private function makeCacheTag(Model $Model)
    {
        return 'lhs'.get_class($Model).'-'.$Model->getKey();
    }

}