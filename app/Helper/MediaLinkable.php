<?php

namespace App\Helper;

use App\MediaInfo;
use App\MediaLinked;
use Illuminate\Support\Facades\Auth;

trait MediaLinkable
{
    public function mediaInfos()
    {
        return $this->morphToMany(MediaInfo::class, 'media_link', 'media_linked');
    }

    public function mediaLinks()
    {
        return $this->morphMany(MediaLinked::class, 'media_link');
    }

    public function unlinkAll()
    {
        $this->relink();
    }

    public function relink($mediaInfoIds = [])
    {
        if (!is_array($mediaInfoIds)) {
            $mediaInfoIds = explode(',', $mediaInfoIds);
        }

        $mediaInfoIds = array_filter($mediaInfoIds);
        $currentMediaLinks = $this->mediaLinks()->pluck('media_info_id')->all();

        $deletions = array_diff($currentMediaLinks, $mediaInfoIds);
        $additions = array_diff($mediaInfoIds, $currentMediaLinks);

        if (count($deletions) > 0) {
            $this->mediaLinks()->whereIn('media_info_id', $deletions)->delete();
        }

        if (count($additions) > 0) {
            $addMedia = [];
            foreach ($additions as $addition) {
                $addMedia[] = $this->mediaLinks()->firstOrCreate(['media_info_id' => $addition]);
            }
            $this->mediaLinks()->saveMany($addMedia);
        }
    }
}
