<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name1' => 'Camilo',
            'name2' => 'Gabriel',
            'surname1' => 'Alvarado',
            'surname2' => 'Ramírez',
        	'email' => 'camilo.alvarado0501@gmail.com',
            'address' => 'Barrio La Isla Avenida Manuel Bonilla Casa #36',
            'country_id' => 97,
            'state_id' => 4047,
            'city_id' => 54048,
            'phone1' => rand(11111111, 99999999),
        	'password' => bcrypt('milogaqw')
        ]);
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Medico']);
        Role::create(['name' => 'Asitente']);
        Role::create(['name' => 'Paciente']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
