<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'user_id',
        'value'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type_id' => 'integer',
        'user_id' => 'integer',
        'value_teste' => 'decimal:2',
    ];

    /**
     * Get the type of the transaction.
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }


    /**
     * Get the originate transaction model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
