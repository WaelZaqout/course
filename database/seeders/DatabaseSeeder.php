<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the RoleAdmin seeder to create roles and permissions
        $this->call([
            RoleAdmin::class,
            PlanSeeder::class,
        ]);

    //     // Create admin user and assign the admin role
    //     $adminUser = User::factory()->create([
    //         'name' => 'wael zaqout',
    //         'email' => 'wael@gmail.com',
    //         'password' => bcrypt('password'),
    //     ]);
    //     // Assign the admin role using Spatie Permission
    //     $adminUser->assignRole('admin');
    }
}
