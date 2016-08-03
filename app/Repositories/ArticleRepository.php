<?php
namespace App\Repositories;

use App\Models\ {
                Article, 
                Comment, 
                ArticleType
};

class ArticleRepository extends BaseRepository
{

    /**
     * The ArticleType instance.
     *
     * @var App\Models\ArticleType
     */
    protected $articleType;

    /**
     * The Comment instance.
     *
     * @var App\Models\Comment
     */
    protected $comment;

    /**
     * Create a new ArticleRepository instance.
     *
     * @param App\Models\Atricle $article            
     * @param App\Models\ArticleType $articleType            
     * @param App\Models\Comment $comment            
     * @return void
     */
    public function __construct(Article $article, ArticleType $articleType, Comment $comment)
    {
        $this->model = $article;
        $this->articleType = $articleType;
        $this->comment = $comment;
    }

    /**
     * Create a query for Article.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function queryActiveWithUserOrderByDate($topicId = 1)
    {
        return $this->model->select('id', 'created_at', 'updated_at', 'title', 'slug', 'user_id', 'description', 'sequence')
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
        return $this->model->select('id', 'created_at', 'updated_at', 'title', 'slug', 'user_id', 'description', 'sequence', 'url')
            ->where('topic_id', $topicId)
            ->whereNull('content.deleted_at')
            ->with('user');
    }

    /**
     * Get post collection.
     *
     * @param int $n            
     * @param int $id            
     * @return Illuminate\Support\Collection
     */
    public function indexTag($n, $topicId, $tagId)
    {
        if ($tagId == 1) {
            $query = $this->queryActiveWithUser($topicId)->latest();
        } elseif ($tagId == 2) {
            $query = $this->queryActiveWithUser($topicId)->orderBy('sequence');
        }
        
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tags.id', $tagId);
        })
            ->paginate($n);
    }

    /**
     * Get content collection.
     *
     * @param string $slug            
     * @return array
     */
    public function show($slug)
    {
        return $article = $this->model->with('tags')
            ->whereSlug($slug)
            ->firstOrFail();
        
        return compact('article');
    }

    /**
     * Create or update an article.
     *
     * @param App\Models\Article $article            
     * @param array $inputs            
     * @param bool $user_id            
     * @return App\Models\Article
     */
    public function saveArticle($article, $inputs, $userId = null)
    {
        $article->topic_id = (int) $inputs['topicId'];
        $article->source_url = strtolower($inputs['sourceUrl']);
        $article->title = ucwords(strtolower($inputs['title']));
        $article->description = ucwords($inputs['description']);
        $article->author_name = $inputs['authorName'] ?? '';
        $article->author_description = $inputs['authorDescription'] ?? '';
        $article->author_picture_id = $inputs['authorImageId'];
        
        $article->slug = $this->generateSlug($article, $inputs['title']);
        $article->article_type_id = (int) $inputs['typeId'];
        if ($userId) {
            $article->user_id = $userId;
        }
        $article->save();
        
        return $article;
    }

    /**
     * Create an article.
     *
     * @param array $inputs            
     * @param int $user_id            
     * @return void
     */
    public function store($inputs, $userId)
    {
        $article = $this->saveArticle(new $this->model(), $inputs, $userId);
        
        return $article;
    }
}