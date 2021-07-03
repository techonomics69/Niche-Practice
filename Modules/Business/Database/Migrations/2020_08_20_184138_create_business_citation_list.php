<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessCitationList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_citation_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('link')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'name' => 'angieslist',
                'image' => 'angieslist.jpg'
            ],
            [
                'name' => 'bbb',
                'image' => 'bbb.jpg'
            ],
            [
                'name' => 'brownbook',
                'image' => 'brownbook.jpg'
            ],
            [
                'name' => 'City Search',
                'image' => 'citysearch.jpg'
            ],
            [
                'name' => 'biz.yelp',
                'image' => 'yelp-large.png'
            ],
            [
                'name' => 'Dex Knows',
                'image' => 'dexknows.jpg'
            ],
            [
                'name' => 'EZ Local',
                'image' => 'ezlocal.jpg'
            ],
            [
                'name' => 'Foursquare',
                'image' => 'foursquare.jpg'
            ],
            [
                'name' => 'HotFrog',
                'image' => 'hofrog.jpg'
            ],
            [
                'name' => 'EZDoctor',
                'image' => 'ezdoctor.jpg'
            ],
            [
                'name' => 'Local.com',
                'image' => 'local.jpg'
            ],
            [
                'name' => 'Manta',
                'image' => 'manta.jpg'
            ],
            [
                'name' => 'Mapquest',
                'image' => 'mapquest.jpg'
            ],
            [
                'name' => 'Merchant',
                'image' => 'merchantcircle.jpg'
            ],
            [
                'name' => 'Superpages',
                'image' => 'superpages.jpg'
            ],
            [
                'name' => 'Yahoo Local',
                'image' => 'yahoo.jpg'
            ],
            [
                'name' => 'Yellow Book',
                'image' => 'yellobook.jpg'
            ],
            [
                'name' => 'Yellow Pages',
                'image' => 'yellowpages.jpg'
            ]
        ];

        foreach($data as $row)
        {
            \Modules\Business\Models\BusinessCitationList::create(
                [
                    'name' => $row['name'],
                    'image' => $row['image']
                ]
            );
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_citation_list');
    }
}
