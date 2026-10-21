<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'name',
        'code',
    ];

    /**
     * Get the faculty to which this department belongs.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get all alumni profiles belonging to this department.
     */
    public function alumniProfiles(): HasMany
    {
        return $this->hasMany(AlumniProfile::class);
    }

    /**
     * Scope a query to filter departments by faculty ID.
     */
    public function scopeByFaculty(Builder $query, int $facultyId): Builder
    {
        return $query->where('faculty_id', $facultyId);
    }
}
