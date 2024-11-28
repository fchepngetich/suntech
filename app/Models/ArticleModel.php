<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $allowedFields = ['title', 'slug', 'content', 'menu_id', 'created_at', 'updated_at'];

    public function getArticleBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getAllArticles()
    {
        return $this->findAll();
    }
}
