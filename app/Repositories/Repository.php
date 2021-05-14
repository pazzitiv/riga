<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;

    public function __construct()
    {
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    abstract public function getById(int $id);

    abstract public function save(Model $model);
}
