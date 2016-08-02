<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'channels';

    /**
     * The timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE') . 'User');
    }
}