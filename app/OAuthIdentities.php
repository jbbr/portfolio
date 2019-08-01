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
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get "iframe" attribute from JSON in field "data"
     * It's used by the provider "schulcloud" to provide raw html
     * which renders an iframe with the name of the loggedin user
     *
     * @return string|null
     */
    public function getIframeAttribute()
    {
        $code = optional($this->data)->iframe;
        if (is_string($code)) {
            // TODO: Currently the userid is not prefilled in iframe code, this replacement should be made obsolete
            return str_replace('{{sub}}', $this->provider_user_id, $code);
        }
        return null;
    }
}
