<?php

namespace Database\Factories;

use App\Models\EmailList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailList>
 */
 
class EmailListFactory extends Factory
{
    protected $model = EmailList::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
        ];
    }
}