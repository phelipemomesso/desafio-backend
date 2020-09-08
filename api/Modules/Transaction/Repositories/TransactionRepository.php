<?php

namespace Modules\Transaction\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface TransactionRepository extends RepositoryInterface
{
    public function export(array $attributes);
}
