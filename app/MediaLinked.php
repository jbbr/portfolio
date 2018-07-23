<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaLinked extends Model
{
    protected $table = "media_linked";
    public $timestamps = false;

    protected $guarded = ['id'];

}
