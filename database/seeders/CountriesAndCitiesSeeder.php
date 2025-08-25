<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = base_path('database/data/countries_and_cities.csv');
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $country = DB::table('countries')->firstOrCreate([
                'code' => $record['country_code'],
                'name' => $record['country_name']
            ]);

            DB::table('cities')->insert([
                'country_id' => $country->id,
                'name' => $record['city_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
