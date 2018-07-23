<?php

namespace App;

use App\Helper\Taggable;
use Illuminate\Database\Eloquent\Model;

class MediaInfo extends Model
{
    use Taggable;

    protected $table = "media_info";

    protected $guarded = ["id"];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function mediaLinks()
    {
        return $this->hasMany( MediaLinked::class );
    }

    public function entries()
    {
        return $this->morphedByMany(Entry::class, 'media_link', 'media_linked');
    }

    public function delete()
    {
        $this->untagAll();

        return parent::delete();
    }
}
