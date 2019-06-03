<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OAuthIdentities extends Model
{
    protected $table = 'oauth_identities';

    protected $fillable = [
        'provider',
        'provider_user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
