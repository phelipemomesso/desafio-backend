<?php

namespace Modules\Core\Services;

use Closure;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

abstract class BaseService
{
    /**
     * The repository instance.
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * The relations to sync of the service instance.
     *
     * Here's an example of options of how to format:
     * <code>
     * [
     *     'create' => [
     *         ['relation' => 'categories', 'attribute' => 'categories', 'detaching' => true]
     *     ],
     *     'update' => ['categories', 'relation2', 'relation3']
     * ];
     * </code>
     *
     * @var array
     */
    protected $syncs = [
        'create' => [],
        'update' => [],
    ];

    public function __construct()
    {
        $this->repository = app($this->repository);
    }

    /**
     * Reset all criteria.
     *
     * @return $this
     */
    public function resetCriteria()
    {
        $this->repository->resetCriteria();
        return $this;
    }

    /**
     * Retrieve data array for populate field select.
     *
     * @param string $column
     * @param string|null $key
     *
     * @return Collection|array
     */
    public function lists($column, $key = null)
    {
        return $this->repository->lists($column, $key);
    }

    /**
     * Retrieve data array for populate field select.
     *
     * @param string $column
     * @param string|null $key
     *
     * @return Collection|array
     */
    public function pluck($column, $key = null)
    {
        return $this->repository->pluck($column, $key);
    }

    /**
     * Sync relations.
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->repository->sync($id, $relation, $attributes, $detaching);
    }

    /**
     * SyncWithoutDetaching.
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->repository->syncWithoutDetaching($id, $relation, $attributes);
    }

    /**
     * Retrieve all data of repository.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->repository->all($columns);
    }

    /**
     * Retrieve all data of repository, paginated.
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'])
    {
        return $this->repository->paginate($limit, $columns);
    }

    /**
     * Retrieve all data of repository, simple paginated.
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*'])
    {
        return $this->repository->simplePaginate($limit, $columns);
    }

    /**
     * Find data by field and value.
     *
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->repository->findByField($field, $value, $columns);
    }

    /**
     * Find data by multiple fields.
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->repository->findWhere($where, $columns);
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->repository->findWhereIn($field, $values, $columns);
    }

    /**
     * Find data by excluding multiple values in one field.
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->repository->findWhereNotIn($field, $values, $columns);
    }

    /**
     * Save a new entity in repository.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $entity = $this->repository->create($attributes);

        foreach ($this->syncs['create'] as $item) {
            if (is_array($item)) {
                if (isset($attributes[data_get($item, 'attribute', $item['relation'])])) {
                    $entity->{$item['relation']}()->sync(
                        $attributes[data_get($item, 'attribute', $item['relation'])],
                        data_get($item, 'detaching', true)
                    );
                }
            } else {
                if (isset($attributes[$item])) {
                    $entity->{$item}()->sync($attributes[$item], true);
                }
            }
        }

        return $this->find($entity->{$entity->getKeyName()});
    }

    /**
     * Find data by id.
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Update a entity in repository by id.
     *
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->repository->update($attributes, $id);

        foreach ($this->syncs['update'] as $item) {
            if (is_array($item)) {
                if (isset($attributes[data_get($item, 'attribute', $item['relation'])])) {
                    $entity->{$item['relation']}()->sync(
                        $attributes[data_get($item, 'attribute', $item['relation'])],
                        data_get($item, 'detaching', true)
                    );
                }
            } else {
                if (isset($attributes[$item])) {
                    $entity->{$item}()->sync($attributes[$item], true);
                }
            }
        }

        return $this->find($entity->{$entity->getKeyName()});
    }

    /**
     * Update or Create an entity in repository.
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->repository->updateOrCreate($attributes, $values);
    }

    /**
     * Delete a entity in repository by id.
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Order collection by a given column.
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->repository->orderBy($column, $direction);
        return $this;
    }

    /**
     * Load relations.
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->repository->with($relations);
        return $this;
    }

    /**
     * Load relation with closure.
     *
     * @param string $relation
     * @param closure $closure
     *
     * @return $this
     */
    public function whereHas($relation, $closure)
    {
        $this->repository->whereHas($relation, $closure);
        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->repository->withCount($relations);
        return $this;
    }

    /**
     * Set hidden fields.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->repository->hidden($fields);
        return $this;
    }

    /**
     * Set visible fields.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->repository->visible($fields);
        return $this;
    }

    /**
     * Query Scope.
     *
     * @param Closure $scope
     *
     * @return $this
     */
    public function scopeQuery(Closure $scope)
    {
        $this->repository->scopeQuery($scope);
        return $this;
    }

    /**
     * Reset Query Scope.
     *
     * @return $this
     */
    public function resetScope()
    {
        $this->repository->resetScope();
        return $this;
    }

    /**
     * Get Searchable Fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->repository->getFieldsSearchable();
    }

    /**
     * Set Presenter.
     *
     * @param $presenter
     *
     * @return mixed
     */
    public function setPresenter($presenter)
    {
        $this->repository->setPresenter($presenter);
        return $this;
    }

    /**
     * Skip Presenter Wrapper.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipPresenter($status = true)
    {
        $this->repository->skipPresenter($status);
        return $this;
    }

    /**
     * Retrieve first data of repository, or return new Entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = [])
    {
        return $this->repository->firstOrNew($attributes);
    }

    /**
     * Retrieve first data of repository, or create new Entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = [])
    {
        return $this->repository->firstOrCreate($attributes);
    }
}
