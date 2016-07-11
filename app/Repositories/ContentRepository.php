<?php

namespace App\Repositories;

use App\Models\Content,
    App\Models\Tag,
    App\Models\Comment;

class ContentRepository extends BaseRepository
{
    /**
     * The Tag instance.
     *
     * @var App\Models\Tag
     */
    protected $tag;

    /**
     * The Comment instance.
     *
     * @var App\Models\Comment
     */
    protected $comment;

    /**
     * Create a new ContentRepository instance.
     *
     * @param  App\Models\Content $content
     * @param  App\Models\Tag $tag
     * @param  App\Models\Comment $comment
     * @return void
     */
    public function __construct(
    Content $content, Tag $tag, Comment $comment)
    {
        $this->model   = $content;
        $this->tag     = $tag;
        $this->comment = $comment;
    }

    /**
     * Create a query for Content.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function queryActiveWithUserOrderByDate($topicId = 1)
    {
        return $this->model
                ->select('id', 'created_at', 'updated_at', 'title', 'slug',
                    'user_id', 'description', 'sequence')
                ->where('topic_id', $topicId)
                ->whereNull('content.deleted_at')
                ->with('user')
                ->latest();
    }

    /**
     * Create a query for Content.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function queryActiveWithUser($topicId = 1)
    {
        return $this->model
                ->select('id', 'created_at', 'updated_at', 'title', 'slug',
                    'user_id', 'description', 'sequence', 'url')
                ->where('topic_id', $topicId)
                ->whereNull('content.deleted_at')
                ->with('user');
    }

    /**
     * Get post collection.
     *
     * @param  int  $n
     * @param  int  $id
     * @return Illuminate\Support\Collection
     */
    public function indexTag($n, $topicId, $tagId)
    {
        if ($tagId == 1) {
            $query = $this->queryActiveWithUser($topicId)->latest();
        } elseif ($tagId == 2) {
            $query = $this->queryActiveWithUser($topicId)->orderBy('sequence');
        }

        return $query->whereHas('tags',
                    function($q) use($tagId) {
                    $q->where('tags.id', $tagId);
                })
                ->paginate($n);
    }

    /**
     * Get content collection.
     *
     * @param  string  $slug
     * @return array
     */
    public function show($slug)
    {
        return $content = $this->model->with('tags')->whereSlug($slug)->firstOrFail();

        return compact('content');
    }
}