<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password'];
    protected $useTimestamps = true; 

    // Add a method to find user by email
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
   
}