<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    private $cmsName = ['skill-set','area-coverage', 'category-list', 'benefit-video', 'benefits-list'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertQuery = [];
        foreach ($this->cmsName as $name) {
            array_push($insertQuery, ['name'=>$name]);
        }
        DB::table('wp_cms')->insert($insertQuery);
    }
}
