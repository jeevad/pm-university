<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_tag';

    /**
     * The timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['article_id', 'tag_id'];

}