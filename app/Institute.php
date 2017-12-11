<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Institute extends Model
{
    use Searchable;
    public function programs(){
        return $this->hasMany('App\Program');
    }
    public function searchableAs()
    {
        return 'institutes_index';
    }
}
