<?php

namespace Modules\User\Services;

use Illuminate\Support\Arr;
use Modules\Core\Services\BaseService;
use Modules\User\Criteria\UserCriteria;
use Modules\User\Repositories\UserRepository;

class UserService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var UserRepository
     */
    protected $repository = UserRepository::class;


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
        return $this->find($entity->{$entity->getKeyName()});
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
        return $this->find($entity->{$entity->getKeyName()});
    }
}
