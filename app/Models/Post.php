<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use SoftDeletes;
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured'
    ];

    public function author(){
        return $this->belongsTo('App\Models\User','user_id'); // ou (User::class,'user_id')
    }
    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }

    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now());
    }

    public function scopeWithCategory($query, string $category){
        $query->whereHas('categories', function ($query) use($category){
            $query;
        });
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

    public function getThumbnailImage(){
        $isUrl = str_contains($this->image,'http');

        return ($isUrl) ? $this->image : Storage::url($this->image);
    }
}
