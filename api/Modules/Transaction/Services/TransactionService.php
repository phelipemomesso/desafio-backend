<?php

namespace Modules\Transaction\Services;

use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Services\BaseService;
use Modules\Transaction\Export\Export;
use Modules\Transaction\Repositories\TransactionRepository;

class TransactionService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var TransactionRepository
     */
    protected $repository = TransactionRepository::class;


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

    public function export(array $attributes)
    {
        $data = $this->repository->export($attributes);

        if (count($data) > 0) {
            $fileName = 'transacoes-' . $attributes['filter_type'] . '-' . date('d.m.Y_His') . '.csv';
            Excel::store(new Export($data), $fileName, 'public');

            return Config::get('app.url')."/storage/".$fileName;
        }

        return false;
    }
}
