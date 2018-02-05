<?php

namespace Halfpetal\Laravel\Identifiable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Identifier extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'identifiable_id', 'identifiable_type'
    ];

    /**
     * The attributes to be cast as dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function identifiable()
    {
        return $this->morphTo();
    }
}
