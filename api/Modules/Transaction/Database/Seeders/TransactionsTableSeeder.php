<?php

namespace Modules\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Transaction\Entities\Transaction;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::create([
            'type_id' => 1,
            'user_id' => 1,
            'value' => 100,
        ]);

        Transaction::create([
            'type_id' => 1,
            'user_id' => 1,
            'value' => 200,
        ]);

        Transaction::create([
            'type_id' => 2,
            'user_id' => 1,
            'value' => 150,
        ]);

        Transaction::create([
            'type_id' => 2,
            'user_id' => 1,
            'value' => 130,
        ]);

        Transaction::create([
            'type_id' => 3,
            'user_id' => 1,
            'value' => 80,
        ]);
    }
}
