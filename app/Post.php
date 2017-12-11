<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function likes(){
        return $this->hasMany('App\Like');
    }
    public function searchableAs()
    {
        return 'posts_index';
    }
}
