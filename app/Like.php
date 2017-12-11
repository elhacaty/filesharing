<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Like extends Model
{
    use Searchable;
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }
    public function searchableAs()
    {
        return 'likes_index';
    }
}
