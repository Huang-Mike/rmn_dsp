<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Permissions of each category.
         */
        // User
        Permission::create(['name'=>'user.view']);
        Permission::create(['name'=>'user.create']);
        Permission::create(['name'=>'user.update']);
        Permission::create(['name'=>'user.delete']);
        // Campaign
        Permission::create(['name'=>'campaign.view']);
        Permission::create(['name'=>'campaign.create']);
        Permission::create(['name'=>'campaign.update']);
        // Strategy
        Permission::create(['name'=>'strategy.view']);
        Permission::create(['name'=>'strategy.create']);
        Permission::create(['name'=>'strategy.update']);
        // Creative
        Permission::create(['name'=>'creative.view']);
        Permission::create(['name'=>'creative.create']);
        Permission::create(['name'=>'creative.update']);
        // Agency
        Permission::create(['name'=>'agency.view']);
        Permission::create(['name'=>'agency.create']);
        Permission::create(['name'=>'agency.update']);
        // Advertiser
        Permission::create(['name'=>'advertiser.view']);
        Permission::create(['name'=>'advertiser.create']);
        Permission::create(['name'=>'advertiser.update']);
        // Log
        Permission::create(['name'=>'log.view']);

        /**
         * Assign permissions to roles.
         */
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'user.view', 'user.create', 'user.update',
            'campaign.view', 'campaign.create', 'campaign.update',
            'strategy.view', 'strategy.create', 'strategy.update',
            'creative.view', 'creative.create', 'creative.update',
            'agency.view', 'agency.create', 'agency.update',
            'advertiser.view', 'advertiser.create', 'advertiser.update',
            'log.view',
        ]);

        $operator = Role::create(['name' => 'Operator']);
        $operator->givePermissionTo([
            'campaign.view', 'campaign.create', 'campaign.update',
            'strategy.view', 'strategy.create', 'strategy.update',
            'creative.view', 'creative.create', 'creative.update',
            'advertiser.view', 'advertiser.create', 'advertiser.update',
            'log.view',
        ]);

        $mike = User::create([
            'name' => 'Mike',
            'email' => 'mike.huang@daexintel.com',
            'password' => Hash::make('a123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mike->assignRole($admin);

    }
}
