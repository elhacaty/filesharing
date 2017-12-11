<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Program extends Model
{
    use Searchable;
    public function institute(){
        return $this->belongsTo('App\Institute');
    }
    public function subjects(){
        return $this->hasMany('App\Subject');
    }
    public function searchableAs()
    {
        return 'programs_index';
    }
}
