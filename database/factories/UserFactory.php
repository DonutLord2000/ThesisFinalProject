<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->userName() . '@example.com',
            'role' => $this->faker->randomElement(['student', 'alumni']),
            'password' => bcrypt('ioripajo'), // Password is hardcoded to 'ioripajo'
            'student_id' => $this->faker->unique()->numerify('#########'),
            'contact_info' => $this->faker->numerify('09#########'), 
            'jobs' => $this->faker->jobTitle(),
            'achievements' => $this->faker->sentence(5),
            'bio' => $this->faker->paragraph(),
            'is_employed' => $this->faker->randomElement(['yes', 'no', 'unknown']),
            'created_at' => Carbon::parse($this->faker->dateTimeThisYear)->format('Y-m-d H:i:s'), // Random date within this year
            'updated_at' => Carbon::parse($this->faker->dateTimeThisYear)->format('Y-m-d H:i:s'), // Same for updated_at
        ];
    }
}
