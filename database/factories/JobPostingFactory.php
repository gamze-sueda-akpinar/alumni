<?php

namespace Database\Factories;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobPosting>
 */
class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Senior Laravel Developer',
            'Full Stack Engineer (Vue / PHP)',
            'Junior Mobile Developer (Flutter)',
            'DevOps & Cloud Engineer',
            'Data Analyst & BI Specialist',
            'AI / ML Research Engineer',
            'UI/UX Product Designer',
            'Cyber Security Analyst',
        ];

        $companies = ['TeknoPlus A.Ş.', 'BulutTech Yazılım', 'FinTech Solutions', 'Peak Yazılım', 'Global Global Media', 'DataCore AI'];
        $locations = ['İstanbul (Hibrit)', 'Ankara (Ofis)', 'İzmir (Hibrit)', 'Uzaktan (Remote)', 'Berlin (Relocation)'];
        $types = ['Full-time', 'Part-time', 'Remote', 'Internship'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($titles),
            'company_name' => fake()->randomElement($companies),
            'location' => fake()->randomElement($locations),
            'type' => fake()->randomElement($types),
            'description' => fake()->paragraphs(2, true),
            'requirements' => fake()->paragraphs(1, true),
            'application_deadline' => fake()->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'contact_email' => fake()->companyEmail(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the job posting is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
