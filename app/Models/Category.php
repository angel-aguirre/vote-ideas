<?php

namespace App\Models;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * DB relations
     */
    public function ideas() {
        return $this->hasMany(Idea::class);
    }
}
