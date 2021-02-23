<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'views', 'answers', 'votes', 'best_answer_id', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
