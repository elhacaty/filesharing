<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Subject extends Model
{
    use Searchable;
    public function program(){
        return $this->belongsTo('App\Program');
    }
    public function posts(){
        return $this->hasMany('App\Post');
    }
    public function searchableAs()
    {
        return 'subjects_index';
    }
}
