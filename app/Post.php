<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','user_id','charges', 'status', 'location', 'description', 'is_available', 'image1', 'image2', 'image3', 'image4'
    ];



    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function ratings()
    {
      return $this->hasMany(Rating::class);
    }

}
