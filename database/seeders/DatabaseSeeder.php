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
    public function run(): void
    {
        $this->seedPermissionsAndRoles();
        $this->seedDefaultUsers();
    }

    private function seedPermissionsAndRoles(): void
    {
        Role::factory()->create(['name' => 'administrator']);
        Role::factory()->create(['name' => 'webmaster']);
    }

    private function seedDefaultUsers(): void
    {
        User::factory()
            ->create(['name' => 'Webmaster User', 'email' => 'webmaster@domain.tld'])
            ->assignRole('webmaster');

        User::factory()
            ->create(['name' => 'Administrator User', 'email' => 'administrator@domain.tld'])
            ->assignRole('administrator');
    }
}
