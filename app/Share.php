<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $guarded = ['id'];

    public function addPortfolio($id)
    {
        $this->shareables()->create(['shareable_id' => $id, 'shareable_type' => Portfolio::class]);
    }

    public function shareables()
    {
        return $this->hasMany(Shareable::class);
    }

    public function portfolios()
    {
        return $this->morphedByMany(Portfolio::class, 'shareable');
    }
}
