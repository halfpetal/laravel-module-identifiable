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
        return \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $identifier)->firstOrFail()->identifiable;
    }

    /**
     * Wrapper around Model::find
     *
     * @param  string $identifier
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findByIdentifier($identifier)
    {
        return \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $identifier)->first()->identifiable;
    }

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function getRouteKey()
    {
        return $this->identifier->identifier;
    }

    /**
     * Used in implicit model binding AND
     * used in explicit model binding if no callback
     * is specified.
     *
     * @param  string $identifier
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function resolveRouteBinding($identifier){
        return \Halfpetal\Laravel\Identifiable\Models\Identifier::where('identifier', $identifier)->first()->identifiable;
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
