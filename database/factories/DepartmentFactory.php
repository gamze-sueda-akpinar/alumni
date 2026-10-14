<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            ['name' => 'Bilgisayar Mühendisliği', 'code' => 'CENG'],
            ['name' => 'Yazılım Mühendisliği', 'code' => 'SENG'],
            ['name' => 'Endüstri Mühendisliği', 'code' => 'IE'],
            ['name' => 'Elektrik-Elektronik Mühendisliği', 'code' => 'EEE'],
            ['name' => 'İşletme', 'code' => 'BA'],
            ['name' => 'İktisat', 'code' => 'ECON'],
            ['name' => 'Uluslararası İlişkiler', 'code' => 'IR'],
            ['name' => 'İç Mimarlık ve Çevre Tasarımı', 'code' => 'IAED'],
        ];

        $dept = fake()->randomElement($departments);

        return [
            'faculty_id' => Faculty::factory(),
            'name' => $dept['name'] . ' ' . fake()->unique()->numberBetween(1, 999),
            'code' => $dept['code'] . fake()->unique()->numberBetween(10, 99),
        ];
    }
}
