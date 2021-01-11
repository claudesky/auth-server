<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A request for authentication
 * 
 * @property-read int $id
 * @property-read int $authorization_source_id
 * @property string $nonce
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AuthenticationRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'authorization_source_id',
        'nonce',
        'status',
    ];
}
