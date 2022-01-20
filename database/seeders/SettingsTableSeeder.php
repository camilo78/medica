<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name' => 'Clinica la Esperanza',
            'avatar' => 'public/images/sin_imagen.jpg',
            'address' => 'Barrio Solares Nuevos, Edificio Aurora N° 36, La Ceiba, Atlantida',
            'phone' => '+504 968547',
            'web' => 'https://laesperanzaclinica.com',
        ]);
        Setting::create([
            'name' => 'Clínica del Doctor Fernandez',
            'avatar' => 'public/images/sin_imagen.jpg',
            'address' => 'Barrio El Centro, Ave Manuel Bonilla N° 36, La Ceiba, Atlantida',
            'phone' => '+504 563526',
            'web' => 'https://laesperanzaclinica.com',
        ]);
    }
}
