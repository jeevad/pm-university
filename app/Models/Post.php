<?php

namespace App\Models;

use App\Presenters\DatePresenter;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use DatePresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * Many to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongToMany
     */
    public function tags()
    {
        return $this->belongsToMany(env('APP_MODEL_NAMESPACE').'Tag');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Comment');
    }
}
