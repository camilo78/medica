<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class PatientAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('id','>',2)->get();

        foreach($users as $user){
            $user->assignRole(['Paciente']);
        }
    }
}

