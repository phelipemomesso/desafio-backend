<?php

namespace Modules\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Transaction\Entities\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['title' => 'Crédito']);
        Type::create(['title' => 'Débito']);
        Type::create(['title' => 'Estorno']);
    }
}
