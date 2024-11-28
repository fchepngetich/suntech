<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutModel extends Model
{
    protected $table = 'about_us';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'image', 'created_at', 'updated_at'];
}
