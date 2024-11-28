<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
   
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];

    // Add validation rules if necessary
    protected $validationRules = [
        'name' => 'required|is_unique[roles.name]',
        'description' => 'permit_empty'
    ];
   
}
