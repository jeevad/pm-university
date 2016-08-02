<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;
use App\Traits\NullableFields;

class Article extends Model
{
    
    use DatePresenter,
        NullableFields;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Validation rules to store an article
     *
     * @var array
     */
    public static $storeArticleRules = [
        'topicId' => 'required|exists:topics,id',
        'tagId' => 'required|exists:tags,id',
        'sourceUrl' => 'required|url|max:255',
        'title' => 'required|max:255',
        'description' => 'required|max:65000',
        'authorName' => 'sometimes|full_name',
        'authorDescription' => 'sometimes',
        'authorPicture' => 'sometimes|image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'author_name' => 'string',
        'author_description' => 'string'
    ];

    /**
     * Many to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\belongToMany
     */
    public function tags()
    {
        return $this->belongsToMany(env('APP_MODEL_NAMESPACE') . 'Tag');
    }

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE') . 'User');
    }

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE') . 'Comment');
    }

    /**
     * Set the author's name.
     *
     * @param string $value            
     * @return string
     */
    public function setAuthorNameAttribute($authorName)
    {
        $this->attributes['author_name'] = $this->nullIfEmpty($authorName);
    }

    /**
     * Set the author's name.
     *
     * @param string $value            
     * @return string
     */
    public function setAuthorDescriptionAttribute($authorDescription)
    {
        $this->attributes['author_description'] = $this->nullIfEmpty($authorDescription);
    }
}