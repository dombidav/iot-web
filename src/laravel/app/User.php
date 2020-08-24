<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Query\Builder;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static Builder where(string $string, array|string|null $key)
 * @method static User find(int $id)
 * @property string email
 * @property string password
 * @property int role
 * @property string ApiKey
 */
class User extends Authenticatable implements JWTSubject
{
    protected $connection = 'mongodb';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logs(){
        return $this->belongsToMany('App\Log');
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getApiKeyAttribute(){
        return $this->attributes['api-key'];
    }

    public function setApiKeyAttribute($value)
    {
        $this->attributes['api-key'] = $value;
    }
}
