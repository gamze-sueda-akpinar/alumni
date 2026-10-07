<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * Class InMemoryUser
 * 
 * Standalone User Model operating without a database connection.
 * Implements full CRUD (Create, Read, Update, Delete) functions 
 * using persistent in-memory caching.
 *
 * @package App\Models
 */
class InMemoryUser
{
    /**
     * Cache key for storing user records without database.
     */
    protected const CACHE_KEY = 'api_users_list';

    public int $id;
    public string $name;
    public string $email;
    public ?string $student_number = null;
    public ?int $graduation_year = null;
    public ?string $department = null;
    public ?string $current_company = null;
    public ?string $current_position = null;
    public string $city = 'İstanbul';
    public string $status = 'approved';
    public string $created_at;
    public ?string $updated_at = null;

    /**
     * InMemoryUser constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        if (!isset($this->created_at)) {
            $this->created_at = now()->toIso8601String();
        }
    }

    /**
     * Default mock user records (Initial dataset without DB).
     *
     * @return array
     */
    public static function defaultUsers(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Gamze Şüeda Akpınar',
                'email' => 'gamze@example.com',
                'student_number' => '2019123456',
                'graduation_year' => 2024,
                'department' => 'Bilgisayar Mühendisliği',
                'current_company' => 'Google',
                'current_position' => 'Software Engineer',
                'city' => 'İstanbul',
                'status' => 'approved',
                'created_at' => '2026-09-30T06:00:00+00:00',
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet.yilmaz@example.com',
                'student_number' => '170102045',
                'graduation_year' => 2021,
                'department' => 'Bilgisayar Mühendisliği',
                'current_company' => 'Trendyol',
                'current_position' => 'Senior Backend Developer',
                'city' => 'İstanbul',
                'status' => 'approved',
                'created_at' => '2026-09-30T06:00:00+00:00',
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Elif Kaya',
                'email' => 'elif.kaya@example.com',
                'student_number' => '190104012',
                'graduation_year' => 2023,
                'department' => 'Yazılım Mühendisliği',
                'current_company' => 'Getir',
                'current_position' => 'Frontend Developer',
                'city' => 'İzmir',
                'status' => 'approved',
                'created_at' => '2026-09-30T06:00:00+00:00',
                'updated_at' => null,
            ],
        ];
    }

    /* =========================================================================
     * READ OPERATIONS (R)
     * ========================================================================= */

    /**
     * List all users.
     *
     * @return array<InMemoryUser>
     */
    public static function all(): array
    {
        $rawUsers = Cache::get(self::CACHE_KEY, self::defaultUsers());
        return array_map(fn($item) => new self($item), $rawUsers);
    }

    /**
     * Find a user by ID.
     *
     * @param int|string $id
     * @return InMemoryUser|null
     */
    public static function find($id): ?self
    {
        $users = Cache::get(self::CACHE_KEY, self::defaultUsers());
        foreach ($users as $user) {
            if ((string) $user['id'] === (string) $id) {
                return new self($user);
            }
        }
        return null;
    }

    /**
     * Find a user by Email address.
     *
     * @param string $email
     * @return InMemoryUser|null
     */
    public static function findByEmail(string $email): ?self
    {
        $users = Cache::get(self::CACHE_KEY, self::defaultUsers());
        foreach ($users as $user) {
            if (strtolower($user['email']) === strtolower($email)) {
                return new self($user);
            }
        }
        return null;
    }

    /* =========================================================================
     * CREATE OPERATIONS (C)
     * ========================================================================= */

    /**
     * Create and store a new user without database connection.
     *
     * @param array $attributes
     * @return InMemoryUser
     */
    public static function create(array $attributes): self
    {
        $users = Cache::get(self::CACHE_KEY, self::defaultUsers());
        $nextId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

        $userData = array_merge([
            'id' => $nextId,
            'city' => 'İstanbul',
            'status' => 'approved',
            'created_at' => now()->toIso8601String(),
            'updated_at' => null,
        ], $attributes);

        $newUser = new self($userData);
        $users[] = $newUser->toArray();
        Cache::forever(self::CACHE_KEY, $users);

        return $newUser;
    }

    /* =========================================================================
     * UPDATE OPERATIONS (U)
     * ========================================================================= */

    /**
     * Update an existing user by ID (Full or Partial update).
     *
     * @param int|string $id
     * @param array $attributes
     * @return InMemoryUser|null
     */
    public static function update($id, array $attributes): ?self
    {
        $users = Cache::get(self::CACHE_KEY, self::defaultUsers());
        $userIndex = null;

        foreach ($users as $index => $user) {
            if ((string) $user['id'] === (string) $id) {
                $userIndex = $index;
                break;
            }
        }

        if ($userIndex === null) {
            return null;
        }

        $attributes['updated_at'] = now()->toIso8601String();
        $updatedData = array_merge($users[$userIndex], $attributes);
        $users[$userIndex] = $updatedData;

        Cache::forever(self::CACHE_KEY, $users);

        return new self($updatedData);
    }

    /* =========================================================================
     * DELETE OPERATIONS (D)
     * ========================================================================= */

    /**
     * Delete a user by ID.
     *
     * @param int|string $id
     * @return InMemoryUser|null Returns deleted user on success, null if not found.
     */
    public static function delete($id): ?self
    {
        $users = Cache::get(self::CACHE_KEY, self::defaultUsers());
        $userIndex = null;
        $deletedData = null;

        foreach ($users as $index => $user) {
            if ((string) $user['id'] === (string) $id) {
                $userIndex = $index;
                $deletedData = $user;
                break;
            }
        }

        if ($userIndex === null) {
            return null;
        }

        array_splice($users, $userIndex, 1);
        Cache::forever(self::CACHE_KEY, $users);

        return new self($deletedData);
    }

    /* =========================================================================
     * UTILITY METHODS
     * ========================================================================= */

    /**
     * Reset the in-memory store back to default mock dataset.
     *
     * @return void
     */
    public static function resetToDefaults(): void
    {
        Cache::forever(self::CACHE_KEY, self::defaultUsers());
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
