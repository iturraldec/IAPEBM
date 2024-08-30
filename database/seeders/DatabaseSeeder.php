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

        // crear roles
        $this->_creaPermiso('Editar');
        $this->_creaPermiso('Consultar');
        $this->_creaPermiso('Imprimir');
        $this->_creaPermiso('Web');        

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());

        // creo el administrador de usuarios
        $user = User::create([
            'code'      => '15075601',
            'name'      => 'Carlos Iturralde',
            'email'     => 'iturraldec@gmail.com',
            'password'  => Hash::make(config('app_config.user_password')),
        ]);

        // le asigno el rol de administrador de usuarios
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

    // crear permisos
    private function _creaPermiso($nombre)
    {
        $permissions = new Permission;

        $permissions->name = $nombre;
        $permissions->guard_name = 'web';
        $permissions->save();
    }
}