<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $admin = Role::create(['name' => 'Administrator']);
        $author = Role::create(['name' => 'Author']);

        //Permisos
        Permission::create(['name' => 'admin.index',
                            'description' => 'Ver el Dashboard'])->syncRoles([$admin, $author]);

        //Categorías
        Permission::create(['name' => 'categories.index',
                            'description' => 'Ver categorías'])->syncRoles([$admin, $author]);
        
        Permission::create(['name' => 'categories.create',
                            'description' => 'Crear categorías'])->assignRole($admin);

        Permission::create(['name' => 'categories.edit',
                            'description' => 'Editar categorías'])->assignRole($admin);

        Permission::create(['name' => 'categories.destroy',
                            'description' => 'Eliminar categorías'])->assignRole($admin);
        
        //Artículos
        Permission::create(['name' => 'articles.index',
                            'description' => 'Ver artículos'])->syncRoles([$admin, $author]);

        Permission::create(['name' => 'articles.create',
                            'description' => 'Crear artículos'])->syncRoles([$admin, $author]);

        Permission::create(['name' => 'articles.edit',
                            'description' => 'Editar artículos'])->syncRoles([$admin, $author]);

        Permission::create(['name' => 'articles.destroy',
                            'description' => 'Eliminar artículos'])->syncRoles([$admin, $author]);

        //Comentarios
        Permission::create(['name' => 'comments.index',
                            'description' => 'Ver comentarios'])->syncRoles([$admin, $author]);

        Permission::create(['name' => 'comments.destroy',
                            'description' => 'Eliminar comentarios'])->syncRoles([$admin, $author]);

        //Usuarios
        Permission::create(['name' => 'users.index',
                            'description' => 'Ver usuarios'])->assignRole($admin);

        Permission::create(['name' => 'users.edit',
                            'description' => 'Editar usuarios'])->assignRole($admin);

        Permission::create(['name' => 'users.destroy',
                            'description' => 'Eliminar usuarios'])->assignRole($admin);                    

        //Roles
        Permission::create(['name' => 'roles.index',
                            'description' => 'Ver roles'])->assignRole($admin);

        Permission::create(['name' => 'roles.create',
                            'description' => 'Crear roles'])->assignRole($admin);

        Permission::create(['name' => 'roles.edit',
                            'description' => 'Editar roles'])->assignRole($admin);

        Permission::create(['name' => 'roles.destroy',
                            'description' => 'Eliminar roles'])->assignRole($admin);

                            
        }
}
