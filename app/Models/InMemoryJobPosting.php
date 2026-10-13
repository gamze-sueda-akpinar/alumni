<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * Class InMemoryJobPosting
 *
 * Standalone JobPosting Model operating without a database connection.
 * Implements full CRUD (Create, Read, Update, Delete) operations
 * using persistent in-memory caching.
 *
 * @package App\Models
 */
class InMemoryJobPosting
{
    /**
     * Cache key for storing job posting records without database.
     */
    protected const CACHE_KEY = 'api_job_postings_list';

    public int $id;
    public string $title;
    public string $company_name;
    public string $location = 'İstanbul (Hibrit)';
    public string $type = 'Tam Zamanlı';
    public string $description;
    public ?string $requirements = null;
    public ?string $application_deadline = null;
    public string $contact_email = 'kariyer@alumni.edu.tr';
    public bool $is_active = true;
    public string $created_at;
    public ?string $updated_at = null;

    /**
     * InMemoryJobPosting constructor.
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
     * Default mock job postings dataset (No database required).
     *
     * @return array
     */
    public static function defaultJobs(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Senior Full-Stack Developer (PHP / Laravel & Vue)',
                'company_name' => 'Trendyol Tech',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Tam Zamanlı',
                'description' => 'E-ticaret platformumuzun ölçeklenebilir mikroservis mimarisinde görev alacak, mezunlarımıza yönelik kıdemli geliştirici arıyoruz.',
                'requirements' => 'En az 3 yıl PHP/Laravel tecrübesi, Vue.js/React bilgisi, REST API & MySQL deneyimi.',
                'application_deadline' => '2026-12-15',
                'contact_email' => 'tech-jobs@trendyol.com',
                'is_active' => true,
                'created_at' => '2026-10-01T09:00:00+03:00',
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'title' => 'AI / LLM Research Engineer',
                'company_name' => 'Google DeepMind',
                'location' => 'Zürih / Uzaktan',
                'type' => 'Tam Zamanlı',
                'description' => 'Büyük dil modelleri (LLM) ve otonom ajan sistemlerinin eğitimi ve değerlendirmesi üzerine çalışacak araştırmacı mühendis.',
                'requirements' => 'Güçlü Python & PyTorch yetkinliği, derin öğrenme temelleri, transformatör mimarileri bilgisi.',
                'application_deadline' => '2026-11-30',
                'contact_email' => 'careers@google.com',
                'is_active' => true,
                'created_at' => '2026-10-03T11:30:00+03:00',
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'title' => 'Siber Güvenlik Uzman Yardımcısı',
                'company_name' => 'ASELSAN',
                'location' => 'Ankara (Yerinde)',
                'type' => 'Tam Zamanlı',
                'description' => 'Kritik savunma projelerinde ağ ve sistem güvenliği analizleri yapacak, sızma testleri uygulayacak mezun mühendisler.',
                'requirements' => 'Bilgisayar veya Elektrik-Elektronik Mühendisliği mezunu, ağ protokolleri ve Linux bilgisi.',
                'application_deadline' => '2026-12-01',
                'contact_email' => 'ik@aselsan.com.tr',
                'is_active' => true,
                'created_at' => '2026-10-05T14:15:00+03:00',
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'title' => 'Bulut ve DevOps Mühendisi',
                'company_name' => 'Microsoft Türkiye',
                'location' => 'İstanbul / Hibrit',
                'type' => 'Tam Zamanlı',
                'description' => 'Azure bulut altyapılarının yönetimi, CI/CD hatlarının otomasyonu ve Kubernetes mimarilerinin kurgulanması.',
                'requirements' => 'Docker, Kubernetes, Terraform ve Azure/AWS tecrübesi.',
                'application_deadline' => '2026-11-20',
                'contact_email' => 'recruitment@microsoft.com',
                'is_active' => true,
                'created_at' => '2026-10-08T16:00:00+03:00',
                'updated_at' => null,
            ],
        ];
    }

    /* =========================================================================
     * READ OPERATIONS (R)
     * ========================================================================= */

    /**
     * List all job postings.
     *
     * @return array<InMemoryJobPosting>
     */
    public static function all(): array
    {
        $raw = Cache::get(self::CACHE_KEY, self::defaultJobs());
        return array_map(fn($item) => new self($item), $raw);
    }

    /**
     * Find a job posting by ID.
     *
     * @param int|string $id
     * @return InMemoryJobPosting|null
     */
    public static function find($id): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultJobs());
        foreach ($list as $item) {
            if ((string) $item['id'] === (string) $id) {
                return new self($item);
            }
        }
        return null;
    }

    /**
     * Get only active job postings.
     *
     * @return array<InMemoryJobPosting>
     */
    public static function active(): array
    {
        return array_values(array_filter(self::all(), fn($item) => $item->is_active));
    }

    /**
     * Filter job postings by company name.
     *
     * @param string $company
     * @return array<InMemoryJobPosting>
     */
    public static function byCompany(string $company): array
    {
        return array_values(array_filter(
            self::all(),
            fn($item) => stripos($item->company_name, $company) !== false
        ));
    }

    /* =========================================================================
     * CREATE OPERATIONS (C)
     * ========================================================================= */

    /**
     * Create and store a new job posting without database connection.
     *
     * @param array $attributes
     * @return InMemoryJobPosting
     */
    public static function create(array $attributes): self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultJobs());
        $nextId = count($list) > 0 ? max(array_column($list, 'id')) + 1 : 1;

        $now = now()->toIso8601String();
        $data = array_merge([
            'id' => $nextId,
            'location' => 'İstanbul (Hibrit)',
            'type' => 'Tam Zamanlı',
            'requirements' => null,
            'application_deadline' => null,
            'contact_email' => 'kariyer@alumni.edu.tr',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => null,
        ], $attributes);

        $data['id'] = $nextId; // Ensure ID cannot be overridden

        $newJob = new self($data);
        $list[] = $newJob->toArray();
        Cache::forever(self::CACHE_KEY, $list);

        return $newJob;
    }

    /* =========================================================================
     * UPDATE OPERATIONS (U)
     * ========================================================================= */

    /**
     * Update an existing job posting by ID.
     *
     * @param int|string $id
     * @param array $attributes
     * @return InMemoryJobPosting|null
     */
    public static function update($id, array $attributes): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultJobs());
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
     * Delete a job posting by ID.
     *
     * @param int|string $id
     * @return InMemoryJobPosting|null
     */
    public static function delete($id): ?self
    {
        $list = Cache::get(self::CACHE_KEY, self::defaultJobs());
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
     * Reset the job postings cache back to default mock dataset.
     *
     * @return void
     */
    public static function resetToDefaults(): void
    {
        Cache::forever(self::CACHE_KEY, self::defaultJobs());
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
