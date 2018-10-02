<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncRolesPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Roles & Permissions defined in ./config/permissions.php file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $guardPermissions = config('permissions');

        foreach ($guardPermissions as $guardKeyName => $permissions) {
            $guardName = str_replace('guard:', '', $guardKeyName);

            $this->setPermissions($guardName, $permissions);
        }
    }

    /**
     * Set Permissions by guard
     *
     * @param string $guardName
     * @param array $permissions
     */
    protected function setPermissions($guardName, $permissions)
    {
        foreach ($permissions as $permissionKey => $permissionData) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionKey,
                'guard_name' => $guardName,
            ]);
            $this->line('Permission "'.$permissionKey.'" is set.');

            $roles = $this->setAndGetRoles($guardName, $permissionData['roles']);
            $permission->syncRoles($roles);
            $this->line('--> Roles: '. implode(',', $permissionData['roles']));
        }
    }

    /**
     * Set Roles
     *
     * @param string $guardName
     * @param array $roles
     * @return array Array of Roles
     */
    protected function setAndGetRoles($guardName, $roles)
    {
        $newRoles = [];
        foreach ($roles as $role) {
            $newRoles[] = Role::firstOrCreate([
                'name' => $role,
                'guard_name' => $guardName,
            ]);
        }

        return $newRoles;
    }
}
