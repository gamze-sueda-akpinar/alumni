<?php

namespace App\Models;

/**
 * Class UserModel
 *
 * Alias/Wrapper for the database-independent User Model with CRUD functions.
 *
 * @package App\Models
 */
class UserModel extends InMemoryUser
{
    // Inherits all non-database CRUD operations from InMemoryUser:
    // - UserModel::all()
    // - UserModel::find($id)
    // - UserModel::findByEmail($email)
    // - UserModel::create($data)
    // - UserModel::update($id, $data)
    // - UserModel::delete($id)
}
