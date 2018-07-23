<?php

namespace App;

use App\Helper\MediaLinkable;
use App\Helper\Taggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use Taggable, MediaLinkable;

    protected $table = 'entries';

    protected $fillable = [
        'title',
        'description',
        'date',
        'date_to',
        'duration',
        'portfolio_id',
        'location_id',
        'wordcount'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function publishedEntries()
    {
        return $this->hasMany(PublishedEntries::class, 'entry_id');
    }

    public function stripedDescription()
    {
        return strip_tags($this->description, '<br><p><strong><em><sup><sub><ol><ul><li><h1><h2><h3><h4><h5><h6>');
    }

    public function delete()
    {
        $this->untagAll();
        $this->unlinkAll();

        return parent::delete();
    }

    public function getDateAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    }

    public function getDateToAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    }
}
