<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Fisionomia;
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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // crear permisos para el administrador
        Permission::create(['name' => 'Usuarios']);
        Permission::create(['name' => 'Sistema']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());

        // creo los administradores
        $user = User::create([
            'code'      => '15075601',
            'name'      => 'Carlos Iturralde',
            'email'     => 'iturraldec@gmail.com',
            'password'  => Hash::make(config('app_config.users_init_password')),
        ]);

        $user->assignRole('Administrador');

        // creo otros permisos
        Permission::create(['name' => 'Personal Administrativo.Crear']);
        Permission::create(['name' => 'Personal Administrativo.Consultar']);
        Permission::create(['name' => 'Personal Administrativo.Actualizar']);
        Permission::create(['name' => 'Personal Administrativo.Eliminar']);
        $personal_administrativo = Permission::create(['name' => 'Personal Administrativo']);

        Permission::create(['name' => 'Personal Obrero.Crear']);
        Permission::create(['name' => 'Personal Obrero.Consultar']);
        Permission::create(['name' => 'Personal Obrero.Actualizar']);
        Permission::create(['name' => 'Personal Obrero.Eliminar']);
        $personal_obrero = Permission::create(['name' => 'Personal Obrero']);

        Permission::create(['name' => 'Personal Uniformado.Crear']);
        Permission::create(['name' => 'Personal Uniformado.Consultar']);
        Permission::create(['name' => 'Personal Uniformado.Actualizar']);
        Permission::create(['name' => 'Personal Uniformado.Eliminar']);
        $personal_uniformado = Permission::create(['name' => 'Personal Uniformado']);

        Permission::create(['name' => 'Web']);

        // creo otros roles
        $role = Role::create(['name' => 'Personal Administrativo.Admin']);
        $role->givePermissionTo($personal_administrativo);

        $role = Role::create(['name' => 'Personal Obrero.Admin']);
        $role->givePermissionTo($personal_obrero);

        $role = Role::create(['name' => 'Personal Uniformado.Admin']);
        $role->givePermissionTo($personal_uniformado);

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