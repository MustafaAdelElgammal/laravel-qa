<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Str;
class Question extends Model
{
    protected $fillable = ['title', 'body', 'votes', 'views', 'answers', 'slug'];
//    protected $fillable = ['title', 'slug', 'body', 'views', 'answers', 'votes', 'best_answer_id', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }

    public function getUrlAttribute(){
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        if ($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
