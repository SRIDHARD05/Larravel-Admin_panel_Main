<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
           'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->userName() . '.' . $this->faker->domainName(),
            'position' => $this->faker->jobTitle(),
            'salary' => $this->faker->randomFloat(2, 30000, 100000),
        ];
    }
}
