<?php

namespace Database\Factories;

use App\Models\AlumniProfile;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AlumniProfile>
 */
class AlumniProfileFactory extends Factory
{
    protected $model = AlumniProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies = ['Trendyol', 'Getir', 'Hepsiburada', 'Google', 'Microsoft', 'Amazon', 'Garanti BBVA', 'Aselsan', 'Havelsan', 'PwC', 'KPMG'];
        $positions = ['Software Engineer', 'Backend Developer', 'Frontend Developer', 'Data Scientist', 'Product Manager', 'Business Analyst', 'Financial Consultant', 'Systems Architect'];
        $cities = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Berlin', 'London', 'Amsterdam'];

        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'student_number' => (string) fake()->unique()->numberBetween(170000000, 240999999),
            'graduation_year' => fake()->numberBetween(2015, 2026),
            'phone' => '+90 5' . fake()->numerify('## ### ####'),
            'current_company' => fake()->randomElement($companies),
            'current_position' => fake()->randomElement($positions),
            'city' => fake()->randomElement($cities),
            'country' => 'Türkiye',
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            'github_url' => 'https://github.com/' . fake()->userName(),
            'bio' => fake()->paragraph(),
            'cv_path' => null,
            'status' => fake()->randomElement(['approved', 'approved', 'approved', 'pending', 'rejected']),
        ];
    }

    /**
     * Indicate that profile is approved.
     */
    public function approved(): static
    {
        return $this->state(fn () => ['status' => 'approved']);
    }

    /**
     * Indicate that profile is pending.
     */
    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }
}
