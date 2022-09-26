<?php

namespace App\Repositories;

abstract class Repository
{
    /**
     * Model's instance
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Repository class constructor
     * 
     * @param  Illuminate\Database\Eloquent\Model  $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Set the coulmns to retrieve from the respective relation.
     * 
     * @example <relation>:<PK>,<attributes>    -   'relation:id,name,image, ...'
     * 
     * @param  string  $attr
     * @return void
     */
    public function selectAttributesForRelationalEntity(string $attr)
    {
        $this->model = $this->model->with($attr);
    }

    /**
     * Set the columns to retrieve from the model.
     * 
     * @example '<attr1>,<attr2>,<attr3>, ...'  -   'id,name,image, ...'
     * 
     * @param  string  $attr
     * @return void
     */
    public function selectAttributesFromModel(string $attr)
    {
        $attr = explode(',', $attr);
        array_push($attr, 'id');

        $this->model = $this->model->select($attr);
    }

    /**
     * Filter all registers in the model.
     * 
     * @example <column>:<condition>:<value>    -   'id:=:3,name:!=:example, ...'
     * 
     * @param  string  $filter
     * @return void
     */
    public function filterRegistersFromModel(string $filters)
    {
        $filters = explode(',', $filters);

        foreach ($filters as $filter) {
            $filter = explode(':', $filter);
            $this->model = $this->model->where($filter[0], $filter[1], $filter[2]);
        }
    }

    /**
     * Return a QueryBuilder of the model.
     * 
     * @return Illuminate\Database\Schema\Builder
     */
    public function getModelBuilder()
    {
        return $this->model;
    }

    /**
     * Return the Collection match with the QeuryBuilder of the model.
     * 
     * @return Illuminate\Database\Schema\Collection
     */
    public function getModelCollection()
    {
        return $this->model->get();
    }
}
