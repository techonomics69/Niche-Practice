<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Business\Models\Niches;

class NichesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $nichesRecord = [
            1 => [
                'Teeth Whitening', 'Dental Implants', 'Laser Dentistry', 'Cad-Cam', 'Sleep Apnea', 'Invisible Braces', 'Sedation Dentistry'
            ],
            2 => [
                'Rhinoplasty', 'Cellulite Reduction', 'Eye Lift', 'Breast Surgery', 'Facelifts', 'Dermal Fillers', 'Liposuction', 'Tattoo Removal'
            ],
            3 => [
                'Dermal Fillers', 'Permanent Makeup', 'Chemical Peels', 'Microdermabrasion', 'Acne Treatment', 'Laser Resurfacing', 'Hair Removal'
            ]
        ];

        foreach ($nichesRecord as $index => $niches)
        {
            foreach ($niches as $nichesIndex => $niche)
            {
                Niches::create(
                    [
                        'niche'=>$niche,
                        'industry_id'=>$index,
                        'status'=> 1
                    ]
                );
            }
        }
    }
}
