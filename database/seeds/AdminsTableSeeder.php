<?php

use App\Eloquents\Admin;
use App\Eloquents\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Roles
         */
        $adminUser = Admin::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ], [
            'active' => 1,
            'password' => 'admin@'.date('Y'),
        ]);

        /**
         * Roles
         */
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'admin',
        ]);

        /**
         * User Role Assign
         */
        $adminUser->assignRole($adminRole);

        // Call "sync:roles-permissions" Command
        Artisan::call('sync:roles-permissions');
    }
}
