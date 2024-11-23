<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Fisionomia;
use Illuminate\Support\Facades\Hash;

//
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // creo los roles
        // rol y permisos del usuario adiministrador
        $role = Role::create(['name' => 'Administrador']);
        $permisos   = [];
        $permisos[] = Permission::create(['name' => 'Admin.Usuarios']);
        $permisos[] = Permission::create(['name' => 'Admin.Sistema']);
        $role->syncPermissions($permisos);

        // rol adiministrador de personal administrativo
        $role = Role::create(['name' => 'Personal Administrativo.Admin']);
        $permisos   = [];
        $permisos[] = Permission::create(['name' => 'Personal Administrativo.Crear']);
        $permisos[] = Permission::create(['name' => 'Personal Administrativo.Consultar']);
        $permisos[] = Permission::create(['name' => 'Personal Administrativo.Actualizar']);
        $permisos[] = Permission::create(['name' => 'Personal Administrativo.Eliminar']);
        $permisos[] = Permission::create(['name' => 'Personal Administrativo.CRUD']);
        $role->syncPermissions($permisos);

        // rol administrador de personal obrero
        $role = Role::create(['name' => 'Personal Obrero.Admin']);
        $permisos   = [];
        $permisos[] = Permission::create(['name' => 'Personal Obrero.Crear']);
        $permisos[] = Permission::create(['name' => 'Personal Obrero.Consultar']);
        $permisos[] = Permission::create(['name' => 'Personal Obrero.Actualizar']);
        $permisos[] = Permission::create(['name' => 'Personal Obrero.Eliminar']);
        $permisos[] = Permission::create(['name' => 'Personal Obrero.CRUD']);
        $role->syncPermissions($permisos);

        // rol administrador de personal uniformado
        $role = Role::create(['name' => 'Personal Uniformado.Admin']);
        $permisos   = [];
        $permisos[] = Permission::create(['name' => 'Personal Uniformado.Crear']);
        $permisos[] = Permission::create(['name' => 'Personal Uniformado.Consultar']);
        $permisos[] = Permission::create(['name' => 'Personal Uniformado.Actualizar']);
        $permisos[] = Permission::create(['name' => 'Personal Uniformado.Eliminar']);
        $permisos[] = Permission::create(['name' => 'Personal Uniformado.CRUD']);
        $role->syncPermissions($permisos);

        // rol de usuarios web
        $role = Role::create(['name' => 'Usuario Web']);
        $permisos   = [];
        $permisos[] = Permission::create(['name' => 'Web.Consultar']);
        $role->syncPermissions($permisos);

        // creo los administradores
        $user = User::create([
            'code'      => '15075601',
            'name'      => 'Carlos Iturralde',
            'email'     => 'iturraldec@gmail.com',
            'password'  => Hash::make(config('app_config.users_init_password')),
        ]);

        $user->assignRole('Administrador');

        // creo los datos fisionomicos
        Fisionomia::create(['descripcion' => 'ESTATURA']);
        Fisionomia::create(['descripcion' => 'COLOR DE TEZ']);
        Fisionomia::create(['descripcion' => 'CABELLO']);
        Fisionomia::create(['descripcion' => 'CARA']);
        Fisionomia::create(['descripcion' => 'FRENTE']);
        Fisionomia::create(['descripcion' => 'CEJAS']);
        Fisionomia::create(['descripcion' => 'OJOS']);
        Fisionomia::create(['descripcion' => 'NARIZ']);
        Fisionomia::create(['descripcion' => 'BOCA']);
        Fisionomia::create(['descripcion' => 'LABIOS']);
        Fisionomia::create(['descripcion' => 'BARBA']);
        Fisionomia::create(['descripcion' => 'BIGOTE']);
        Fisionomia::create(['descripcion' => 'CONTEXTURA']);
        Fisionomia::create(['descripcion' => 'DENTADURA']);
        Fisionomia::create(['descripcion' => 'PESO']);
        Fisionomia::create(['descripcion' => 'SEÑALES PARTICULARES']);
        Fisionomia::create(['descripcion' => 'LENTES']);
        Fisionomia::create(['descripcion' => 'TALLA DE CAMISA']);
        Fisionomia::create(['descripcion' => 'TALLA DE PANTALON']);
        Fisionomia::create(['descripcion' => 'TALLA DE CALZADO']);
        Fisionomia::create(['descripcion' => 'TALLA DE GORRA']);
    }
}