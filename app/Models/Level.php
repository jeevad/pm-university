<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'levels';

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Topic');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function topics()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Topic');
    }
}
