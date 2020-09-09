<?php

namespace Modules\Transaction\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transaction\Entities\Transaction;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionRepositoryEloquent extends BaseRepository implements TransactionRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function export(array $filters)
    {
        switch ($filters['filter_type']) {
            case 'all':
                return $this->model->where('user_id', $filters['user_id'])->get();
            case 'monthYear':
                return $this->model
                    ->where('user_id', $filters['user_id'])
                    ->where(DB::raw('DATE_FORMAT(created_at,"%m/%Y")'), $filters['date_filter'])
                    ->get();
            case 'last30days':
                return $this->model
                    ->where('user_id', $filters['user_id'])
                    ->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();
            default:
                return $this->model->all();
        }
    }
}
