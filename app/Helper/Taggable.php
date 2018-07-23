<?php

namespace App\Helper;

use App\Tag;
use Illuminate\Support\Facades\Auth;

trait Taggable
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->orderBy('name', 'ASC');
    }

    public function tagged()
    {
        return $this->morphMany(\App\Taggable::class, 'taggable');
    }

    public function untagAll()
    {
        $this->retag();
    }

    public function retag($tags = [])
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        $tags = array_filter($tags);
        $currentTagNames = $this->tags()->pluck('name')->all();

        $deletions = array_diff($currentTagNames, $tags);
        $additions = array_diff($tags, $currentTagNames);

        if (count($deletions) > 0) {
            $deleteTags = Auth::user()->tags()->whereIn('name', $deletions)->pluck('id')->all();
            $this->tagged()->whereIn('tag_id', $deleteTags)->delete();
        }

        if (count($additions) > 0) {
            $addTags = [];
            foreach ($additions as $addition) {
                $addTags[] = Auth::user()->tags()->firstOrCreate(['name' => $addition]);
            }
            $this->tags()->saveMany($addTags);
        }
    }
}
