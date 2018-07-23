<?php

namespace App;

use App\Mail\PasswordReset;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profession',
        'date_of_birth',
        'location_of_birth',
        'street',
        'city',
        'phone',
        'education',
        'email_token',
        'training_date_from',
        'training_date_to',
        'picture',
        'verified',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function entries()
    {
        return $this->hasManyThrough(Entry::class, Portfolio::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function mediaInfos()
    {
        return $this->hasMany(MediaInfo::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'media_info');
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function publishes()
    {
        return $this->hasMany(Publish::class);
    }

    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    public function getDateOfBirthAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getTrainingDateFromAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getTrainingDateToAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new PasswordReset($this, $token));
    }

    private function formatDate($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function getPicturePath()
    {
        return ($this->picture ? Storage::url($this->picture) : null);
    }

    public function isAdmin()
    {
        return (bool)$this->is_admin;
    }

    public function delete()
    {
        $this->locations()->delete();
        $this->shares()->delete();
        $this->publishes()->delete();


        $this->entries()->delete();
        $this->portfolios()->delete();
        $this->mediaInfos()->delete();

        return parent::delete();
    }
}
