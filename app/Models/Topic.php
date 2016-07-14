<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;

class Topic extends Model
{

    //use DatePresenter;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * Validation rules to store a topic
     *
     * @var array
     */
    public static $storeTopicRules = [
        'url' => 'required|max:255',
        'title' => 'required|max:255',
        'description' => 'required|max:65000',
        'topicPicture' => 'sometimes',
        'levelId' => 'required|exists:levels,id',
        'authorName' => 'sometimes',
        'authorDescription' => 'sometimes',
        'authorPicture' => 'sometimes',
        'h1' => 'sometimes',
        'metaTitle' => 'sometimes',
        'metaDescription' => 'sometimes',
        'metaKeywords' => 'sometimes'
    ];

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'User');
    }

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'Level');
    }

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Comment');
    }
}