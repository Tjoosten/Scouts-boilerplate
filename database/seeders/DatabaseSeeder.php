<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @todo Implement method for truncating the database tables.
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedPermissionsAndRoles();
        $this->seedDefaultUsers();
    }

    /**
     * Method for seeding all the default application roles.
     *
     * @return void
     */
    private function seedPermissionsAndRoles(): void
    {
        Role::factory()->create(['name' => 'administrator']);
        Role::factory()->create(['name' => 'webmaster']);
    }

    /**
     * Method for adding all the default users in the application.
     *
     * @return void
     */
    private function seedDefaultUsers()
    {
        User::factory()
            ->create(['name' => 'Webmaster User', 'email' => 'webmaster@domain.tld'])
            ->assignRole('webmaster');

        User::factory()
            ->create(['name' => 'Administrator User', 'email' => 'administrator@domain.tld'])
            ->assignRole('administrator');
    }
}
