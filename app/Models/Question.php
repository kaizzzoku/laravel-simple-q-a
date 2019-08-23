<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
    	'user_id',
    	'title',
    	'description',
    	'is_published',
    	'is_completed',
    ];



    /**** Relationships ****/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class);
    }

    public function answers()
    {
    	return $this->hasMany(Answer::class);
    }

    public function comments()
    {
    	return $this->morphMany(Comment::class, 'commentable');
    }

    /**** Accessors ****/

    public function getTagsTitleAttribute()
    {
        return ($this->tags_count > 1) ?
            $this->tags->first()->title . ' + ' . ($this->tags_count - 1)
            :
            $this->tags->first()->title;
    }

    /**** Scopes ****/

    public function scopeGetPaginatedIndex($query, int $per_page = 20)
    {
        $columns = ['id', 'user_id', 'title', 'created_at'];

        return $query
            ->withCount('answers', 'tags')
            ->with(['tags:id,title'])
            ->paginate($per_page, $columns);
    }

    public function scopeGetForShow($query, int $id)
    {
        return $query
            ->withCount('comments')
            ->with([
                'answers' => function ($query) {
                    $query->withCount('comments');
                },
                'tags:id,slug,title',
                'comments.user:id,name,first_name,last_name',
                'answers.user:id,name,first_name,last_name',
                'answers.comments.user:id,name,first_name,last_name'
            ])
            ->find($id);
    }

    public function getSolutionsAttribute()
    {
        return $this->answers
            ->where('is_solution', 1)
            ->all();
    }
    
    public function getNotSolutionsAttribute()
    {
        return $this->answers
            ->where('is_solution', 0)
            ->all();
    }
}

