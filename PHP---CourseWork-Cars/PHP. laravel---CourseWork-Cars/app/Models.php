<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = "models";
    protected $fillable = ["name","makes_id"];

    public function cars() {
        return $this->hasMany("App\Cars");
    }

    public function makes() {
        return $this->belongsTo("App\Makes", 'makes_id');
    }
}
