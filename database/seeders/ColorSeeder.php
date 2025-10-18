<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name_ar' => 'أحمر', 'name_en' => 'Red', 'hex' => '#FF0000'],
            ['name_ar' => 'أزرق', 'name_en' => 'Blue', 'hex' => '#0000FF'],
            ['name_ar' => 'أخضر', 'name_en' => 'Green', 'hex' => '#008000'],
            ['name_ar' => 'أصفر', 'name_en' => 'Yellow', 'hex' => '#FFFF00'],
            ['name_ar' => 'برتقالي', 'name_en' => 'Orange', 'hex' => '#FFA500'],
            ['name_ar' => 'بنفسجي', 'name_en' => 'Purple', 'hex' => '#800080'],
            ['name_ar' => 'وردي', 'name_en' => 'Pink', 'hex' => '#FFC0CB'],
            ['name_ar' => 'بني', 'name_en' => 'Brown', 'hex' => '#A52A2A'],
            ['name_ar' => 'رمادي', 'name_en' => 'Gray', 'hex' => '#808080'],
            ['name_ar' => 'أسود', 'name_en' => 'Black', 'hex' => '#000000'],
            ['name_ar' => 'أبيض', 'name_en' => 'White', 'hex' => '#FFFFFF'],
            ['name_ar' => 'ذهبي', 'name_en' => 'Gold', 'hex' => '#FFD700'],
            ['name_ar' => 'فضي', 'name_en' => 'Silver', 'hex' => '#C0C0C0'],
            ['name_ar' => 'نيلي', 'name_en' => 'Navy', 'hex' => '#000080'],
            ['name_ar' => 'تركوازي', 'name_en' => 'Turquoise', 'hex' => '#40E0D0'],
            ['name_ar' => 'مرجاني', 'name_en' => 'Coral', 'hex' => '#FF7F50'],
            ['name_ar' => 'ليموني', 'name_en' => 'Lime', 'hex' => '#00FF00'],
            ['name_ar' => 'كريمي', 'name_en' => 'Cream', 'hex' => '#FFF8DC'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
