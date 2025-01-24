<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'creator_id',
        'date',
        'location',
        'picture',
        'type',
        'description',
    ];

    //Disabling the created_at, updated_at
    public $timestamps = false;
}
