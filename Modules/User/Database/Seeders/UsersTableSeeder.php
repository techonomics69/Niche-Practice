<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'id'=>'1',
            'email'=>'admin@nichepractice.com',
            'first_name'=>'System',
            'last_name'=>'Admin',
            'password' => bcrypt('David_Access123'),
            'remember_token' => '',
        ]);
    }
}
