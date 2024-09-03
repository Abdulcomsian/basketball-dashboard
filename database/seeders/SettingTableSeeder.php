<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'store_name'             => 'Store Name',
                'email'          => 'store@mail.com',
                'address'          => 'USA',
            ],
        ];

        SiteSetting::insert($settings);
    }
}
