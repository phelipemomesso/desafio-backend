<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::create(
            [
                'name' => 'Phelipe Momesso',
                'email' => 'phelipe.momesso@gmail.com',
                'password' => bcrypt('12345678'),
                'birthdate' => '1985-08-12',
            ]
        );
    }
}
