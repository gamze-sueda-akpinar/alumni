<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Genel', 'Etkinlik', 'Kariyer', 'Burs & Akademi'];
        $audiences = ['Tüm Mezunlar', 'Mühendislik Mezunları', 'İİBF Mezunları', 'Yeni Mezunlar', 'Lisansüstü Adayları'];

        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement($categories),
            'author' => 'Mezunlar Ofisi',
            'target_audience' => fake()->randomElement($audiences),
            'is_pinned' => fake()->boolean(25),
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the announcement is pinned.
     */
    public function pinned(): static
    {
        return $this->state(fn () => ['is_pinned' => true]);
    }

    /**
     * Indicate that the announcement is draft.
     */
    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
