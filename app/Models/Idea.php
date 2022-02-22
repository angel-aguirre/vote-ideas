<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Status;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];
    protected $perPage = 5;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * DB relations 
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function votes() {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * Custom methods
     */
    public function isVotedByUser(?User $user) {
        if(!$user) {
            return false;
        }

        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function vote(User $user) {
        Vote::create([
            'user_id' => $user->id,
            'idea_id' => $this->id,
        ]);
    }

    public function removeVote(User $user) {
        Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->first()
            ->delete();
    }
}
