<?php

namespace Database\Factories;

use App\Models\Command;
use Faker\Provider\ru_RU\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Command::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Company::companyNameElement() . ' ' . rand(1,99),
        ];
    }
}
