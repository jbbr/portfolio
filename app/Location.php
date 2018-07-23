<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'description',
        'person',
        'email',
        'phone',
        'street',
        'city',
        'type',
        'additionals',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function uses()
    {
        return $this->entries()->count();
    }

    public function delete()
    {
        $this->entries()->update(['location_id' => null]);

        return parent::delete();
    }

    public function getAdditionalsAttribute($value)
    {
        return json_decode($value);
    }

    public function getTypeTranslation() {
        switch($this->type) {
            case 'general':
                return "Allgemein";
                break;
            case 'school':
                return "Schule";
                break;
            case 'business':
                return "Betrieb";
                break;
        }
    }
}
