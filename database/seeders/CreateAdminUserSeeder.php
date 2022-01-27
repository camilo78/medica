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
        	'password' => bcrypt('milogaqw'),
        ]);

        $admin = Role::create(['name' => 'Admin']);
        $medic = Role::create(['name' => 'Médico']);
        $asistant = Role::create(['name' => 'Asistente']);
        $patient = Role::create(['name' => 'Paciente']);

        $permissions_admin = Permission::pluck('id','id')->all();
        $admin->syncPermissions($permissions_admin);

        $permissions_medic = Permission::where('name', 'like', "%user-%")
            ->orWhere('name', 'like', "%setting-%")
            ->pluck('id','id')->all();
        $medic->syncPermissions($permissions_medic);

        $permissions_asistente = Permission::where('name', 'like', "%user-%")
            ->pluck('id','id')->all();
        $asistant->syncPermissions($permissions_asistente);

        $permissions_patient = Permission::where('name', "user-show")->where('name', "user-edit")
            ->pluck('id','id')->all();
        $patient->syncPermissions($permissions_patient);

        $user->assignRole([$admin->id]);
    }
}
