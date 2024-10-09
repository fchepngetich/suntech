<?php

namespace App\Models;

use CodeIgniter\Model;

class SubsubcategoryModel extends Model
{
    protected $table = 'subsubcategories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['subcategory_id', 'name', 'slug', 'description', 'created_at', 'updated_at'];

    // Generate slug from the name
    public function createSlug($name)
    {
        return url_title($name, '-', true);
    }

    // Fetch subsubcategories by subcategory
    public function getBySubcategory($subcategory_id)
    {
        return $this->where('subcategory_id', $subcategory_id)->findAll();
    }
}