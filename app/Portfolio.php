<?php

namespace App;

use App\Helper\MediaLinkable;
use App\Helper\Taggable;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use Taggable, MediaLinkable;

    protected $table = 'portfolios';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'sort',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function locations()
    {
        $entriesIds = $this->entries->pluck('id')->toArray();

        return Location::whereHas('entries', function ($qry) use ($entriesIds) {
            $qry->whereIn('id', $entriesIds);
        })->get();
    }

    public function delete()
    {
        $this->entries()->delete();
        $this->untagAll();
        $this->unlinkAll();

        return parent::delete();
    }
}
