<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_types';

    /**
     * Many to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\belongToMany
     */
    public function articles()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE') . 'Article');
    }
}