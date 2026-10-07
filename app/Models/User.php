<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
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
    | Non-Database In-Memory CRUD Operations (Prototype Mode)
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

