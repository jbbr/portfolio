<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function entries()
    {
        return $this->morphedByMany(Entry::class, 'taggable');
    }

    public function portfolios()
    {
        return $this->morphedByMany(Portfolio::class, 'taggable');
    }

    public function mediaInfos()
    {
        return $this->morphedByMany(MediaInfo::class, 'taggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taggables()
    {
        return $this->hasMany(Taggable::class);
    }

    public function uses()
    {
        return $this->taggables()->count();
    }

    public function delete()
    {
        $this->taggables()->delete();

        return parent::delete();
    }
}
