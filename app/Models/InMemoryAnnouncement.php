<?php

namespace App\Models;

/**
 * Class InMemoryAnnouncement
 *
 * Alias/subclass for Announcement model operating in memory without database.
 *
 * @package App\Models
 */
class InMemoryAnnouncement extends Announcement
{
    // Inherits all non-database CRUD operations:
    // - InMemoryAnnouncement::all()
    // - InMemoryAnnouncement::find($id)
    // - InMemoryAnnouncement::published()
    // - InMemoryAnnouncement::pinned()
    // - InMemoryAnnouncement::byCategory($category)
    // - InMemoryAnnouncement::create($attributes)
    // - InMemoryAnnouncement::update($id, $attributes)
    // - InMemoryAnnouncement::delete($id)
}
