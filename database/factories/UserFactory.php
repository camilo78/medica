<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name1' => $this->faker->firstName(),
            'name2' => $this->faker->firstName(),
            'surname1' => $this->faker->lastName(),
            'surname2' => $this->faker->lastName(),
            'married_name' => $this->faker->lastName(),
            //'avatar',
            'email' => $this->faker->unique()->safeEmail(),
            'phone1' => rand(11111111, 99999999),
            'phone2' => rand(11111111, 99999999),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'civil' => $this->faker->randomElement(['Single','Married']),
            'birth' => $this->faker->dateTimeBetween($startDate = '-70 years', $endDate = 'now', $timezone = 'America/Tegucigalpa')->format('Y-m-d'), // DateTime('2003-03-15 02:00:49', 'America/Tegucigalpa')
            'patient_code' => $this->faker->ean8(),
            'document_type' => $this->faker->randomElement(['ID number']),
            'document' => $this->faker->ean13(),
            'status' => 'Active',
            'name_relation' => $this->faker->name(),
            'kinship' => $this->faker->randomElement(['No responsible','Spouse','Mother','Father','Partner','Son or Daughter','Aunt or Uncle','Cousin','Other']),
            'address' => $this->faker->address(),
            'country_id' => 97,
            'state_id' => 4047,
            'city_id' => 54048,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'setting_id' =>1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

    }
}

