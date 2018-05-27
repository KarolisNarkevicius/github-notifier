<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $guarded = ['id'];

    public function getHtmlUrlAttribute()
    {
        return 'https://github.com/' . $this->full_name;
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

}
