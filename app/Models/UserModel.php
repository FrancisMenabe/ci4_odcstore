<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom', 'pseudo', 'email', 'password', 'role', 'profile', 'statut', 'date_creation'
    ];
    protected $useTimestamps = false;
}
