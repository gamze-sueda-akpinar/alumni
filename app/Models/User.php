<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'role',
    ];

    /**
     * Default attributes.
     * By domain requirement: Until official verification is completed,
     * every user defaults to the 'student' role with baseline privileges.
     */
    protected $attributes = [
        'role' => 'student',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check if the user is unverified / pending official verification.
     * Users awaiting diploma/academic review remain unverified while holding the student role.
     */
    public function isUnverified(): bool
    {
        return $this->role === 'unverified' 
            || ($this->alumniProfile && $this->alumniProfile->status === 'pending');
    }

    /**
     * Check if the user is a verified account.
     */
    public function isVerified(): bool
    {
        return !$this->isUnverified();
    }

    /**
     * Check if the user acts with student capabilities.
     * All unverified users act as students by default until approved.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student' || $this->role === 'unverified';
    }

    /**
     * Check if the user is an approved alumnus/alumna.
     */
    public function isAlumni(): bool
    {
        return $this->role === 'alumni' && (!$this->alumniProfile || $this->alumniProfile->status === 'approved');
    }

    /**
     * Check if the user is an approved academic faculty member.
     */
    public function isAcademic(): bool
    {
        return $this->role === 'academic' && (!$this->alumniProfile || $this->alumniProfile->status === 'approved');
    }

    /**
     * Check if the user is a system administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if user can apply for jobs.
     * Allowed for: student (including unverified users defaulting to student), alumni, and admin.
     */
    public function canApplyForJobs(): bool
    {
        return in_array($this->role, ['student', 'unverified', 'alumni', 'admin']);
    }

    /**
     * Determine if user can share job postings.
     * Allowed for: verified alumni and admin.
     */
    public function canShareJobPostings(): bool
    {
        return in_array($this->role, ['alumni', 'admin']) && $this->isVerified();
    }

    /**
     * Determine if user can create and host events.
     * Allowed for: verified academic staff and admin.
     */
    public function canCreateEvents(): bool
    {
        return in_array($this->role, ['academic', 'admin']) && $this->isVerified();
    }

    protected $appends = [
        'student_number',
        'graduation_year',
        'department',
        'current_company',
        'current_position',
        'city',
        'status',
    ];

    /**
     * Get the alumni profile associated with the user.
     */
    public function alumniProfile(): HasOne
    {
        return $this->hasOne(AlumniProfile::class);
    }

    /**
     * Get all professional experiences for the user.
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get all job postings authored by the user.
     */
    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }

    /**
     * Get all job applications submitted by this user.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Alias for applications submitted by this user.
     */
    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
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
