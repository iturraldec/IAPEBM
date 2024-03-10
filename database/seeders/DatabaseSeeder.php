<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());

        // creo el administrador de usuarios
        $user = User::create([
            'name'              => 'Jean Pier',
            'document_number'   => '12345678',
            'email'             => 'jeanpier@gmail.com',
            'password'          => Hash::make('12345678')
        ]);

        // le asigno el rol de administrador de usuarios
        $user->assignRole('Administrador');
        
        // permisos de prueba
        for($i = 1; $i <= 10; $i++) {
            $permissions = new Permission;

            $permissions->name = Str::random(50);
            $permissions->guard_name = 'web';
            $permissions->save();
        }

        // roles de prueba
        for($i = 1; $i <= 10; $i++) {
            $roles = new Role;

            $roles->name = Str::random(50);
            $roles->guard_name = 'web';
            $roles->save();
        }

        // usuarios de prueba
        User::factory(10)->create();
    }
}