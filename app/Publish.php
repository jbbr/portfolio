<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publish extends Model
{
    protected $table = "publishes";

    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'url'
    ];

    public function publishedEntries()
    {
        return $this->hasMany(PublishedEntries::class, 'publish_id', 'id');
    }

    public function delete()
    {
        $this->publishedEntries()->delete();

        return parent::delete();
    }
}
