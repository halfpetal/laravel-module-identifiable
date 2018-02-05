<?php

namespace Halfpetal\Laravel\Identifiable\Traits;

/**
 * Class Identifiable
 * @package  Halfpetal\Laravel\Identifiable\Traits
 */
trait Identifiable
{
    public static function boot()
    {
        parent::boot();

        if(isset(static::$idNoAutoGenerate) && static::$idNoAutoGenerate) {
            return;
        }

        self::created(function ($model) {
            $id = new \Halfpetal\Laravel\Identifiable\Models\Identifier();
            $id->identifier = $model->generateIdentifier();

            $model->identifier()->save($id);
        });
    }

    /**
     * Wrapper around Model::findOrFail
     *
     * @param  string $identifier
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findByIdentifierOrFail($identifier)
    {
        $id = \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $identifier)->firstOrFail();
        return static::findOrFail($id->identifiable->id);
    }

    /**
     * Wrapper around Model::find
     *
     * @param  string $identifier
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findByIdentifier($identifier)
    {
        $id = \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $identifier)->first();
        return static::find($id->identifiable->id);
    }

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function getRouteKey()
    {
        return $this->identifier->identifier;
    }

    public function generateIdentifier()
    {
        $idLength = isset(static::$idLength) ? static::$idLength : 7;
        $id = '';

        do {
            $id = str_random($idLength);
            $result = \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $id)->first();
        } while(!empty($result));

        return $id;
    }

    public function identifier()
    {
        return $this->morphOne('\Halfpetal\Laravel\Identifiable\Models\Identifier', 'identifiable');
    }
}
