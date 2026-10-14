<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'student_number',
        'graduation_year',
        'department',
        'current_company',
        'current_position',
        'city',
        'status',
    ];

    public function alumniProfile()
    {
        return $this->hasOne(AlumniProfile::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Seamless Accessors for Profile Attributes in Views & API
    |--------------------------------------------------------------------------
    */

    public function getStudentNumberAttribute(): ?string
    {
        return $this->alumniProfile?->student_number;
    }

    public function getGraduationYearAttribute(): ?int
    {
        return $this->alumniProfile?->graduation_year;
    }

    public function getDepartmentAttribute(): ?string
    {
        return $this->alumniProfile?->department?->name;
    }

    public function getCurrentCompanyAttribute(): ?string
    {
        return $this->alumniProfile?->current_company;
    }

    public function getCurrentPositionAttribute(): ?string
    {
        return $this->alumniProfile?->current_position;
    }

    public function getCityAttribute(): ?string
    {
        return $this->alumniProfile?->city;
    }

    public function getCountryAttribute(): ?string
    {
        return $this->alumniProfile?->country ?? 'Türkiye';
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->alumniProfile?->phone;
    }

    public function getLinkedinUrlAttribute(): ?string
    {
        return $this->alumniProfile?->linkedin_url;
    }

    public function getGithubUrlAttribute(): ?string
    {
        return $this->alumniProfile?->github_url;
    }

    public function getBioAttribute(): ?string
    {
        return $this->alumniProfile?->bio;
    }

    public function getStatusAttribute(): string
    {
        return $this->alumniProfile?->status ?? 'approved';
    }

    /*
    |--------------------------------------------------------------------------
    | Non-Database In-Memory CRUD Operations (Prototype Fallback)
    |--------------------------------------------------------------------------
    */

    public static function inMemoryAll(): array
    {
        return InMemoryUser::all();
    }

    public static function inMemoryFind($id): ?InMemoryUser
    {
        return InMemoryUser::find($id);
    }

    public static function inMemoryCreate(array $data): InMemoryUser
    {
        return InMemoryUser::create($data);
    }

    public static function inMemoryUpdate($id, array $data): ?InMemoryUser
    {
        return InMemoryUser::update($id, $data);
    }

    public static function inMemoryDelete($id): ?InMemoryUser
    {
        return InMemoryUser::delete($id);
    }
}
