<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublishedEntries extends Model
{
    protected $table = "published_entries";

    protected $fillable = [
        'publish_id',
        'entry_id'
    ];

    public function publish()
    {
        return $this->belongsTo(Publish::class);
    }

    public function entries()
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }
}
