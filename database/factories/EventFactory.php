<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            '2026 Yıllık Mezunlar Networking Yemeği',
            'Webinar: Yapay Zeka Devriminde Kariyer Stratejileri',
            'Girişimcilik ve Yatırımcı Buluşması',
            'Alumni Tech Talks #12: Microservices & Event-Driven Architecture',
            'Yurt Dışı Kariyer ve Göç Deneyimleri Paneli',
            'Mezunlar Arası Masa Tenisi ve Satranç Turnuvası',
        ];

        $isOnline = fake()->boolean(40);

        return [
            'title' => fake()->randomElement($titles),
            'description' => fake()->paragraphs(2, true),
            'event_date' => fake()->dateTimeBetween('+1 week', '+6 months'),
            'location' => $isOnline ? 'Online (Zoom / Meet)' : 'Ana Kampüs Kongre Merkezi',
            'is_online' => $isOnline,
            'meeting_link' => $isOnline ? 'https://zoom.us/j/' . fake()->numerify('##########') : null,
            'is_active' => true,
        ];
    }
}
