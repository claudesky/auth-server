<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An external source of authorization
 * 
 * @property-read int $id
 * @property string $name
 * @property string $client_id
 * @property string $client_secret
 * @property array $config
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AuthorizationSource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'client_id',
        'client_secret',
        'config',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'array',
    ];

    public function authentication_requests()
    {
        return $this->hasMany(AuthenticationRequest::class);
    }
}
