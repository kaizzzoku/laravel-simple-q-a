<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'first_name',
        'last_name',
        'briefly_about_myself',
        'about_myself',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Redifinition default route key
     *
     * @param void
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**** Relationships ****/

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**** Scopes ****/

    public function scopeGetPaginatedIndex($query, int $per_page = 20)
    {
        $columns = ['id', 'name', 'email', 'created_at'];

        return $query
            #->withCount(['questions', 'answers'])
            ->paginate($per_page, $columns);
    }

    public function scopeGetForShow($query, string $name)    
    {
        return $query
            ->withCount('questions', 'answers')
            ->where('name', $name)
            ->first();
    }

    public function scopeGetShowQuestions($query, string $name)
    {
        return $query
            ->withCount('questions', 'answers')
            ->with(['questions:id,title',
                    'questions.tags',
                    'questions' => function ($query) {
                        $query->withCount('answers');
            }])
            ->where('name', $name)
            ->first();
    }

    public function scopeGetShowAnswers($query, string $name)
    {
        return $query
            ->withCount('questions', 'answers')
            ->with('answers',
                'answers.user:id,name,first_name,last_name',
                'answers.question:id,title')
            ->where('name', $name)
            ->first();
    }

    public function scopeGetShowComments($query, string $name)
    {
        $questions_ids = [];

        return $query
            ->withCount('questions', 'answers')
            ->with([
                'comments',
                'comments.user:id,name,first_name,last_name',
                ])
            ->where('name', $name)
            ->first();

    }
    /**** Accessors ****/

    /**
     * summary
     *
     * @param void
     * @return void
     */
    public function getProfileNameAttribute()
    {
        return $this->first_name . $this->last_name ? 
            $this->first_name . " " . $this->last_name : $this->name;
    }

    /******** Custom functions ********/

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function setAdminRole()
    {
        $this->role = 'admin';
    }

    public function isModerator()
    {
        return $this->role == 'moderator';
    }

    public function setModeratorRole()
    {
        $this->role = 'moderator';
    }

    public function getRoles()
    {
        return ['admin', 'moderator', 'user'];
    }
}
