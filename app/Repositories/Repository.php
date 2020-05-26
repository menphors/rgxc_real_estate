<?php

namespace App\Repositories;

/**
 * Laravel version 5.6
 * Eloquent for MongoDB
 * Using jenssegers/mongodb package
 * 
 * @author SK saly.kong12@gmail.com
 */
abstract class Repository
{
    protected $model;

    /**
     * Create instance of model.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function instance(array $attributes = [])
    {
        return $this->model->fill($attributes);
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function update(array $data)
    {
        $found = $this->find($data['id']);

        $found->update($data);

        return $found;
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Count number of model.
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string|null  $key
     * @return collection
     */
    public function pluck($column, $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    public function model()
    {
        return $this->model;
    }

    public function all($columns = ['*'])
    {   
        return ( $this->model instanceof \Illuminate\Database\Eloquent\Builder )
                    ? $this->model->get($columns)
                    : $this->model->all($columns);
    }
    
    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = 20, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->model->paginate($limit, $columns, $pageName, $page);
    }
    
    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*']){
        return $this->model->where($field, '=', $value)->get($columns);   
    }
    
    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);
        
        return $this->model->get($columns);
    }
    
    /**
     * Find data by multiple values in one field
     *
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }
    /**
     * Find data by excluding multiple values in one field
     *
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }
    
    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function deleteWhere(array $where)
    {
        $this->applyConditions($where);
        
        return $this->model->delete();
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->model->orderBy($column, $direction);
    }

    /**
     * Add a descending "order by" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function orderByDesc($column)
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Get the first record from datastore.
     *
     * @author SoS <semsphy@gmail.com>
     *
     * @return Model
     */
    public function first($columns = ['*'])
    {
        return $this->model->first($columns);
    }
    
    /**
     * Set model
     * 
     * @param Illuminate\Database\Eloquent\Model $mdoel
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
    
    public function latest($column = 'created_at')
    {
        return $this->model->latest($column);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }
}
