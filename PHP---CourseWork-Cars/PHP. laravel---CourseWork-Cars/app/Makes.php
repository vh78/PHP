<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Makes extends Model
{
    protected $table = "makes";
    protected $fillable = ["name","year"];

    public function models() {
        return $this->hasMany('App\Model');
    }
}
