<?php

namespace App\Models;

use App\Presenters\DatePresenter;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use DatePresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'User');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'Topic');
    }
}
