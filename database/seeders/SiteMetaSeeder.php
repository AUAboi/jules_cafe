<?php

namespace Database\Seeders;

use App\Models\SiteMeta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteMeta::create([
            'tables' => 11,
            'is_closed' => false
        ]);
    }
}
