<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{

    //use DatePresenter;
    use SoftDeletes;
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
        'sourceUrl' => 'required|url|max:255',
        'title' => 'required|max:255',
        'description' => 'required|max:65000',
        'topicPicture' => 'sometimes',
        'levelId' => 'required|exists:levels,id',
        'file' => 'sometimes|image',
        'authorName' => 'sometimes|full_name',
        'authorDescription' => 'sometimes',
        'authorPicture' => 'sometimes|image',
        'h1' => 'sometimes',
        'metaTitle' => 'sometimes',
        'metaDescription' => 'sometimes',
        'metaKeywords' => 'sometimes'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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