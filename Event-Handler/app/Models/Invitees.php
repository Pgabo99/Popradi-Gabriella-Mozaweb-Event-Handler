<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitees extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'confirmed',
    ];

    //Disabling the created_at, updated_at
    public $timestamps = false;
}
