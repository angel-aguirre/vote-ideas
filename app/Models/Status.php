<?php

namespace App\Models;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     *  DB relations
     */
    public function ideas() {
        return $this->hasMany(Idea::class);
    }

    /**
     *  Model accessors
     */
    public function getGetClassAttribute() {
        $allStatuses = [
            'Open' => 'bg-gray-200',
            'Considering' => 'bg-purple text-white',
            'In Progress' => 'bg-yellow text-white',
            'Implemented' => 'bg-green text-white',
            'Closed' => 'bg-red text-white',
        ];

        return $allStatuses[$this->name];
    }
}
