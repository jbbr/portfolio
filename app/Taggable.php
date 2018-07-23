<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    protected $table = 'taggables';
    public $timestamps = false;

    protected $guarded = ['id'];
}
