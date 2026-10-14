<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faculties = [
            ['name' => 'Mühendislik ve Doğa Bilimleri Fakültesi', 'code' => 'MDBF'],
            ['name' => 'İktisadi, İdari ve Sosyal Bilimler Fakültesi', 'code' => 'İİSBF'],
            ['name' => 'Tıp Fakültesi', 'code' => 'TF'],
            ['name' => 'Hukuk Fakültesi', 'code' => 'HF'],
            ['name' => 'Mimarlık ve Tasarım Fakültesi', 'code' => 'MTF'],
            ['name' => 'İletişim Fakültesi', 'code' => 'İF'],
        ];

        $faculty = fake()->randomElement($faculties);

        return [
            'name' => $faculty['name'] . ' ' . fake()->unique()->numberBetween(1, 999),
            'code' => $faculty['code'] . fake()->unique()->numberBetween(10, 99),
        ];
    }
}
