<?php

namespace App\Repositories;

use App\Contracts\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 2, 2017 1:05:11 PM
 * File         : BaseRepository.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
abstract class BaseRepository implements RepositoryInterface
{

    const PAGINATION = 15;

    /**
     * Model associated with the repository
     *
     * @var string $model
     */
    protected $model = null;

    /**
     * Relations to include when running query
     *
     * @var array $with
     */
    protected $with = [];

    /**
     * @var Model|Builder $instance
     */
    protected $instance = null;

    /**
     * Repository constructor
     */
    public function __construct()
    {
        $this->createModelInstance();
    }

    /**
     * Instantiate model
     * @return void
     */
    protected function createModelInstance()
    {
        $modelClass = $this->model;
        if (!$modelClass) {
            throw new \Exception('Model class is not defined');
        }
        $this->instance = $this->instance ? : new $modelClass;
    }

    /**
     * Get all resource collections
     *
     * @return Collection|null
     */
    public function findAll()
    {
        return $this->instance->all();
    }

    /**
     * Get model instance
     * @return Model|Builder
     */
    public function model()
    {
        $modelClass = $this->model;
        $model      = $this->instance ? : new $modelClass;
        return $model;
    }

    /**
     * Get collections of resource with pagination
     * @param  int $pagination No of records per page
     * @return
     */
    public function findAllWithPagination($pagination = null)
    {
        if (is_null($pagination)) {
            $pagination = self::PAGINATION;
        }
        return $this->instance->paginate($pagination);
    }

    /**
     * @param $field
     * @param null $value
     * @param null $operator
     * @return Collection|null
     */
    public function findByField($field, $value = null, $operator = null)
    {
        if (is_array($field)) {
            return $this->instance->where($field)->get();
        }
        if ($operator) {
            return $this->instance->where($field, $operator, $value)->get();
        }
        return $this->instance->where($field, $value)->get();
    }

    /**
     * Create new record
     * @param  array $inputs
     * @return Model $model
     */
    public function create(array $inputs)
    {
        $resource = $this->instance->create($inputs);
        return $resource;
    }

    /**
     * Update existing record
     * @param  int|Model $id
     * @param  array $inputs
     * @return Model $model
     */
    public function update($id, array $inputs)
    {
        if (!$id instanceof $this->model) {
            $resource = $this->findById($id);
        }
        else {
            $resource = $id;
        }
        return $resource->update($inputs) ? $resource : false;
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function findById($id)
    {
        return $this->instance->find($id);
    }

    /**
     * Delete record
     * @param  int $id Resource ID
     * @return bool
     */
    public function delete($id)
    {
        if (!$id instanceof $this->model) {
            $resource = $this->findById($id);
        }
        else {
            $resource = $id;
        }
        return $resource->delete();
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function persist($model)
    {
        $model->save();
        return $model;
    }

    /**
     * Call model methods
     * @param  string $name
     * @param  $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->instance->__call($name, $arguments);
        return $this;
    }

    /**
     * @return $this
     */
    public function includeTrash()
    {
        $traitsUsed = class_uses($this->instance);
        if (!empty($traitsUsed) && array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', $traitsUsed)) {
            $this->instance = $this->instance->withTrashed();
        }
        return $this;
    }

}

/* End of file BaseRepository.php */