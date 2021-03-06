<?php

namespace Modules\User\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Delete a entity in repository by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $entity = $this->repository->find($id);

        if ($entity->id == Auth::id()) {
            throw new \Exception('You can not delete your user!');
        }

        if ($entity->initial_amount > 0 or $entity->current_amount > 0 or $entity->transactions()->exists()) {
            throw new \Exception('You can not delete a user with a balance or transaction!');
        }

        return $this->repository->delete($id);
    }


    /**
     * Update initial amount entity in repository by id.
     *
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     */
    public function initialAmount(array $attributes, $id)
    {
        $entity = $this->repository->update($attributes, $id);
        return $this->find($entity->{$entity->getKeyName()});
    }


    /**
     * Get balance entity in repository by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function balance($id)
    {
        $entity = $this->repository->find($id);
        return $entity->initial_amount + $entity->current_amount;
    }
}
