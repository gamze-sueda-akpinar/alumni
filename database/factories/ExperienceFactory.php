<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = ['Amazon', 'Google', 'Trendyol', 'Getir', 'Turkcell', 'Vodafone', 'Garanti BBVA', 'Siemens', 'Beko'];
        $positions = ['Junior Developer', 'Mid-Level Engineer', 'Senior Specialist', 'Team Lead', 'Engineering Manager'];
        $types = ['Full-time', 'Part-time', 'Contract', 'Internship'];

        $startDate = fake()->dateTimeBetween('-5 years', '-1 year');
        $isCurrent = fake()->boolean(60);
        $endDate = $isCurrent ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'user_id' => User::factory(),
            'company_name' => fake()->randomElement($companies),
            'position' => fake()->randomElement($positions),
            'employment_type' => fake()->randomElement($types),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'is_current' => $isCurrent,
            'description' => fake()->sentence(12),
        ];
    }
}
