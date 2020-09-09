<?php

namespace Modules\Transaction\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransactionDatabaseSeeder extends Seeder
{
    /**
     * The tables to be truncated before of seeding.
     *
     * @var array
     */
    protected $truncates = [
        'transaction_transactions',
        'transaction_types'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Schema::disableForeignKeyConstraints();

        foreach ($this->truncates as $table) {
            $this->command->getOutput()->writeln(sprintf('<comment>Truncating:</comment> %s', $table));
            DB::statement(sprintf('TRUNCATE TABLE %s;', $table));
            $this->command->getOutput()->writeln(sprintf('<info>Truncated:</info> %s', $table));
        }

        $this->call(TypesTableSeeder::class);
        $this->call(TransactionTableSeeder::class);

        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }
}
