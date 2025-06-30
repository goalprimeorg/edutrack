<?php

namespace Database\Seeders;

use App\Enums\RequestResourceType;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::LearningMaterial->value,
            ],
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::TeachingMaterial->value,
            ],
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::LearningMaterial->value,
            ],
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::TeachingMaterial->value,
            ],
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::LearningMaterial->value,
            ],
            [
                'name' => fake()->colorName(),
                'request_resource_type' => RequestResourceType::TeachingMaterial->value,
            ],
        ];
        foreach ($items as $item) {
            Item::create($item);
        }

    }
}
