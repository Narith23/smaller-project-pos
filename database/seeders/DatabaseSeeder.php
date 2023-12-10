<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = config('backpack.permissionmanager.models.role');

        $superAdmin = $roleModel::firstOrCreate(['id' => 1], ['name' => 'Superadmin']);
        $admin = $roleModel::firstOrCreate(['id' => 2], ['name' => 'Admin']);
        $editor = $roleModel::firstOrCreate(['id' => 3], ['name' => 'Editor']);
        $user = $roleModel::firstOrCreate(['id' => 4], ['name' => 'User']);
        $customer = $roleModel::firstOrCreate(['id' => 5], ['name' => 'Customer']);
        $employee = $roleModel::firstOrCreate(['id' => 6], ['name' => 'Employee']);

        collect([
            'users',
            'articles',
            'tags',
            'categories',
            'pages',
            'customer',
            'employee',
            'product',
            'order',
            'order_detail',
            'position',
            'brand',
            'type',
        ])->each(function($v) use ($superAdmin, $admin, $editor, $user) {
            collect([
                'list',
                'create',
                'update',
                'show',
                'delete',
            ])->each(function($vv) use ($v, $superAdmin, $admin, $editor, $user) {
                $permission = config('backpack.permissionmanager.models.permission')::firstOrCreate(['name' => "{$vv} {$v}"]);
                $superAdmin->givePermissionTo($permission->name);
                $admin->givePermissionTo($permission->name);
                if (!in_array($v, ['users', 'pages']) && $vv != 'delete') {
                    $editor->givePermissionTo($permission->name);
                }
                if (!in_array($v, ['users', 'pages']) && !in_array($vv, ['delete', 'update', 'create'])) {
                    $user->givePermissionTo($permission->name);
                }
            });
        });

        $userData = config('backpack.permissionmanager.models.user')::firstOrCreate([
            'email' => 'duch.dinarith@gmail.com',
        ], [
            'first_name' => 'Duch',
            'last_name' => 'Dinarith',
            'phone' => '0974337625',
            'password' => '123456@Abc',
        ]);
        $userData->assignRole($superAdmin->name);

        $this->call(SettingsTableSeeder::class);
    }
}
