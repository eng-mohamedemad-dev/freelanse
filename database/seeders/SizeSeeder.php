<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            ['name_ar' => 'صغير', 'name_en' => 'Small'],
            ['name_ar' => 'متوسط', 'name_en' => 'Medium'],
            ['name_ar' => 'كبير', 'name_en' => 'Large'],
            ['name_ar' => 'كبير جداً', 'name_en' => 'Extra Large'],
            ['name_ar' => 'XXL', 'name_en' => 'XXL'],
            ['name_ar' => 'XXXL', 'name_en' => 'XXXL'],
            ['name_ar' => '28', 'name_en' => '28'],
            ['name_ar' => '30', 'name_en' => '30'],
            ['name_ar' => '32', 'name_en' => '32'],
            ['name_ar' => '34', 'name_en' => '34'],
            ['name_ar' => '36', 'name_en' => '36'],
            ['name_ar' => '38', 'name_en' => '38'],
            ['name_ar' => '40', 'name_en' => '40'],
            ['name_ar' => '42', 'name_en' => '42'],
            ['name_ar' => '44', 'name_en' => '44'],
            ['name_ar' => '46', 'name_en' => '46'],
            ['name_ar' => '48', 'name_en' => '48'],
            ['name_ar' => '50', 'name_en' => '50'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
