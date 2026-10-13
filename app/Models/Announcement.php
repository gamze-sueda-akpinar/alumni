<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * Class Announcement
 *
 * Standalone Announcement Model operating without a database connection.
 * Implements full CRUD (Create, Read, Update, Delete) operations 
 * using persistent in-memory caching.
 *
 * @package App\Models
 */
class Announcement
{
    /**
     * Cache key for storing announcement records without database.
     */
    protected const CACHE_KEY = 'api_announcements_list';

    public int $id;
    public string $title;
    public string $content;
    public string $category = 'Genel';
    public string $author = 'Mezunlar Ofisi';
    public ?string $target_audience = 'Tüm Mezunlar';
    public bool $is_pinned = false;
    public string $status = 'published';
    public ?string $published_at = null;
    public string $created_at;
    public ?string $updated_at = null;

    /**
     * Announcement constructor.
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

        if (!isset($this->published_at) && $this->status === 'published') {
            $this->published_at = $this->created_at;
        }
    }

    /**
     * Default mock announcements dataset (No database required).
     *
     * @return array
     */
    public static function defaultAnnouncements(): array
    {
        return [
            [
                'id' => 1,
                'title' => '2026 Yıllık Mezunlar Zirvesi ve Kariyer Fuarı',
                'content' => 'Üniversitemizin geleneksel mezunlar zirvesi bu yıl 25 Kasım tarihinde ana kampüs kongre merkezinde gerçekleştirilecektir. Sektör liderleriyle paneller ve mezun buluşmaları sizleri bekliyor.',
                'category' => 'Etkinlik',
                'author' => 'Mezunlar İlişkileri Koordinatörlüğü',
                'target_audience' => 'Tüm Mezunlar',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => '2026-10-01T10:00:00+03:00',
                'created_at' => '2026-10-01T09:30:00+03:00',
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'title' => 'Global Teknoloji Şirketleri Mentorluk Programı Başvuruları Başladı',
                'content' => 'Google, Trendyol ve Microsoft bünyesinde çalışan kıdemli mezunlarımızın, yeni mezun ve son sınıf öğrencilerimize rehberlik edeceği 6 aylık kariyer mentorluk programı başvuruları açıldı.',
                'category' => 'Kariyer',
                'author' => 'Kariyer Geliştirme Merkezi',
                'target_audience' => 'Mühendislik ve İİBF Mezunları',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => '2026-10-05T14:00:00+03:00',
                'created_at' => '2026-10-05T13:45:00+03:00',
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'title' => 'Yurt Dışı Yüksek Lisans ve Araştırma Bursu Başvuru Rehberi',
                'content' => 'Avrupa ve Amerika\'daki anlaşmalı üniversitelerimizle mezunlarımıza özel sağlanan tam kapsamlı araştırma bursları ve son başvuru tarihleri portalımıza eklendi.',
                'category' => 'Burs & Akademi',
                'author' => 'Uluslararası İlişkiler Ofisi',
                'target_audience' => 'Lisansüstü Adayları',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => '2026-10-08T11:00:00+03:00',
                'created_at' => '2026-10-08T10:15:00+03:00',
                'updated_at' => null,
            ],
        ];
    }

    /* =========================================================================
     * READ OPERATIONS (R)
     * ========================================================================= */

    /**
     * List all announcements.
     *
     * @return array<Announcement>
     */
    public static function all(): array
    {
        $raw = Cache::get(self::CACHE_KEY, self::defaultAnnouncements());
        return array_map(fn($item) => new self($item), $raw);
    }

    /**
     * Find an announcement by ID.
     *
     * @param int|string $id
     * @return Announcement|null
     */
    public static function find($id): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultAnnouncements());
        foreach ($list as $item) {
            if ((string) $item['id'] === (string) $id) {
                return new self($item);
            }
        }
        return null;
    }

    /**
     * Get only published announcements.
     *
     * @return array<Announcement>
     */
    public static function published(): array
    {
        return array_values(array_filter(self::all(), fn($item) => $item->status === 'published'));
    }

    /**
     * Get pinned / highlighted announcements.
     *
     * @return array<Announcement>
     */
    public static function pinned(): array
    {
        return array_values(array_filter(self::all(), fn($item) => $item->is_pinned));
    }

    /**
     * Filter announcements by category.
     *
     * @param string $category
     * @return array<Announcement>
     */
    public static function byCategory(string $category): array
    {
        return array_values(array_filter(
            self::all(),
            fn($item) => strtolower($item->category) === strtolower($category)
        ));
    }

    /* =========================================================================
     * CREATE OPERATIONS (C)
     * ========================================================================= */

    /**
     * Create and store a new announcement without database connection.
     *
     * @param array $attributes
     * @return Announcement
     */
    public static function create(array $attributes): self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultAnnouncements());
        $nextId = count($list) > 0 ? max(array_column($list, 'id')) + 1 : 1;

        $now = now()->toIso8601String();
        $data = array_merge([
            'id' => $nextId,
            'category' => 'Genel',
            'author' => 'Mezunlar Ofisi',
            'target_audience' => 'Tüm Mezunlar',
            'is_pinned' => false,
            'status' => 'published',
            'published_at' => $now,
            'created_at' => $now,
            'updated_at' => null,
        ], $attributes);

        $data['id'] = $nextId; // Ensure ID cannot be overridden

        $newAnnouncement = new self($data);
        $list[] = $newAnnouncement->toArray();
        Cache::forever(self::CACHE_KEY, $list);

        return $newAnnouncement;
    }

    /* =========================================================================
     * UPDATE OPERATIONS (U)
     * ========================================================================= */

    /**
     * Update an existing announcement by ID (Full or Partial).
     *
     * @param int|string $id
     * @param array $attributes
     * @return Announcement|null
     */
    public static function update($id, array $attributes): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultAnnouncements());
        $targetIndex = null;

        foreach ($list as $index => $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetIndex = $index;
                break;
            }
        }

        if ($targetIndex === null) {
            return null;
        }

        $attributes['updated_at'] = now()->toIso8601String();
        $updatedData = array_merge($list[$targetIndex], $attributes);
        $list[$targetIndex] = $updatedData;

        Cache::forever(self::CACHE_KEY, $list);

        return new self($updatedData);
    }

    /* =========================================================================
     * DELETE OPERATIONS (D)
     * ========================================================================= */

    /**
     * Delete an announcement by ID.
     *
     * @param int|string $id
     * @return Announcement|null Returns deleted announcement on success, null if not found.
     */
    public static function delete($id): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultAnnouncements());
        $targetIndex = null;
        $deletedData = null;

        foreach ($list as $index => $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetIndex = $index;
                $deletedData = $item;
                break;
            }
        }

        if ($targetIndex === null) {
            return null;
        }

        array_splice($list, $targetIndex, 1);
        Cache::forever(self::CACHE_KEY, $list);

        return new self($deletedData);
    }

    /* =========================================================================
     * UTILITY METHODS
     * ========================================================================= */

    /**
     * Reset the announcement store back to default mock dataset.
     *
     * @return void
     */
    public static function resetToDefaults(): void
    {
        Cache::forever(self::CACHE_KEY, self::defaultAnnouncements());
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

    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
