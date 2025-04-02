<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 10 ; $i++) { 
                $data = [
                    'name' => 'brand'.$i,
                    'slug' => 'slug'.$i,
                    'description' => 'description'.$i,
                    'logo' => 'logo'.$i
                ];
                Brand::insert($data);
            }
    }
}
