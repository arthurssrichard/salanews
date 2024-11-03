<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(){
        return $this->belongsTo('App\Models\User','user_id'); // ou (User::class,'user_id')
    }

    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now());
    }

    public function scopeFeatured($query){
        $query->where('featured',true);
    }

    public function getExcerpt(){
        return Str::limit($this->body,100,'...');
    }

    public function getReadingTime(){
        $words = str_word_count($this->body);
        $minutes = round($words/250);
        return ($minutes < 1) ?  1 : $minutes;
    }
}
