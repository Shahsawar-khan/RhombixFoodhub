<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Support\Str;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Pizza', 'Chicken Fajita Pizza', 'Delicious chicken fajita with cheese', 850, true],
            ['Pizza', 'Pepperoni Pizza', 'Classic pepperoni pizza', 950, true],
            ['Pizza', 'Tikka Pizza', 'Desi tikka flavor pizza', 900, false],

            ['Burger', 'Zinger Burger', 'Crispy chicken zinger burger', 450, true],
            ['Burger', 'Beef Burger', 'Juicy beef patty burger', 550, false],
            ['Burger', 'Cheese Burger', 'Double cheese burger', 600, false],

            ['Biryani', 'Chicken Biryani', 'Aromatic chicken biryani', 350, true],
            ['Biryani', 'Beef Biryani', 'Spicy beef biryani', 450, false],

            ['Chinese', 'Chicken Chowmein', 'Stir-fried noodles', 400, true],
            ['Chinese', 'Manchurian', 'Chicken manchurian', 450, false],

            ['BBQ', 'Chicken Tikka', 'Grilled chicken tikka', 350, true],
            ['BBQ', 'Seekh Kabab', 'Beef seekh kabab', 400, false],

            ['Desserts', 'Chocolate Cake', 'Rich chocolate cake slice', 300, true],
            ['Desserts', 'Gulab Jamun', 'Traditional gulab jamun (4 pcs)', 200, false],

            ['Drinks', 'Cold Drink', 'Soft drink 500ml', 100, false],
            ['Drinks', 'Fresh Juice', 'Fresh orange juice', 200, true],
        ];

        foreach ($items as $item) {
            $category = Category::where('name', $item[0])->first();
            if ($category) {
                MenuItem::create([
                    'category_id' => $category->id,
                    'name' => $item[1],
                    'slug' => Str::slug($item[1]) . '-' . uniqid(),
                    'description' => $item[2],
                    'price' => $item[3],
                    'is_available' => true,
                    'is_featured' => $item[4],
                ]);
            }
        }
    }
}