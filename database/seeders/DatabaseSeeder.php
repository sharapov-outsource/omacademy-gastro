<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create the default admin user if it does not exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Check by email
            [
                'name' => 'Admin User', // Admin name
                'password' => Hash::make('Hello123'), // Hashing the password before storing
                'role' => 'admin', // Admin role
            ]
        );

        // Create the default waiter user if it does not exist
        User::firstOrCreate(
            ['email' => 'waiter@example.com'], // Check by email
            [
                'name' => 'Waiter User', // Waiter name
                'password' => Hash::make('Hello123'), // Hashing the password before storing
                'role' => 'waiter', // Waiter role
            ]
        );

        // Path to the CSV file (adjust to match your file location)
        $filePath = database_path('seeders/menu.csv');

        // Open the CSV file for reading
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000)) !== false) {
                // Parse CSV columns
                [$menuName, $categoryName, $price, $description] = $row;

                // Find or create the category
                $category = Category::firstOrCreate(['name' => $categoryName]);

                // Create the menu item
                Menu::create([
                    'name' => $menuName,
                    'category_id' => $category->uuid,
                    'price' => $price,
                    'description' => $description,
                ]);
            }

            fclose($handle);

        }
    }
}
