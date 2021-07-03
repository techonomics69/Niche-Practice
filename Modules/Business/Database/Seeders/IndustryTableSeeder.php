<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Business\Models\Industry;

class IndustryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Industry::create(
            [
            'id'=>'1',
            'name'=>'DENTISTRY',
            'status'=> 1
            ]
        );
        Industry::create(
            [
                'id'=>'2',
                'name'=>'PLASTIC SURGERY',
                'status'=> 1
            ]
        );

        Industry::create(
            [
                'id'=>'3',
                'name'=>'MEDISPA',
                'status'=> 1
            ]
        );
    }
}
