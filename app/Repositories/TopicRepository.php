<?php

namespace App\Repositories;

use App\Models\Topic,
    App\Models\Level;

class TopicRepository extends BaseRepository
{
    /**
     * The Location instance.
     *
     * @var App\Models\Location
     */
    protected $level;

    /**
     * Create a new TopicRepository instance.
     *
     * @param  App\Models\Post $post
     * @return void
     */
    public function __construct(
    Topic $topic, Level $level)
    {
        $this->model = $topic;
        $this->level = $level;
    }

    /**
     * Get topic collection.
     *
     * @param  int     $n
     * @param  int     $levelId
     * @param  string  $orderby
     * @param  string  $direction
     * @return Illuminate\Support\Collection
     */
    public function index($n, $levelId = l, $orderby = 'created_at',
                          $direction = 'desc')
    {
        $model = 'level';
        $query = $this->model
            ->with('level')
           // ->select('topics.id', 'topics.created_at', 'title', 'user_id',
              //  'slug')
            ->where('level_id', $levelId)
            ->whereNull('topics.deleted_at');
            //->latest();

        return $query->paginate($n);
    }

    /**
     * Get topic collection.
     *
     * @param  string  $slug
     * @return array
     */
    public function show($slug)
    {
        $post = $this->model->with('user', 'tags')->whereSlug($slug)->firstOrFail();

        $comments = $this->comment
            ->wherePost_id($post->id)
            ->with('user')
            ->whereHas('user',
                function($q) {
                $q->whereValid(true);
            })
            ->get();

        return compact('post', 'comments');
    }

    /**
     * Create or update a topic.
     *
     * @param  App\Models\Topic $topic
     * @param  array  $inputs
     * @param  bool   $user_id
     * @return App\Models\Topic
     */
    private function saveTopic($topic, $inputs, $userId = null)
    {
        $topic->level_id           = (int) $inputs['levelId'];
        $topic->url                = strtolower($inputs['url']);
        $topic->title              = ucwords(strtolower($inputs['title']));
        $topic->description        = ucwords($inputs['description']);
        $topic->author_name        = isset($inputs['authorName']) ? ucwords(strtolower($inputs['authorName']))
                : null;
        $topic->author_description = isset($inputs['authorDescription']) ? ucwords(strtolower($inputs['authorDescription']))
                : null;
        $topic->h1                 = isset($inputs['h1']) ? $inputs['h1'] : null;
        $topic->meta_title         = isset($inputs['metaTitle']) ? $inputs['meteTitle']
                : null;
        $topic->meta_description   = isset($inputs['metaDescription']) ? $inputs['metaDescription']
                : null;
        $topic->meta_keywords      = isset($inputs['metaKeywords']) ? $inputs['metaKeywords']
                : null;
        $topic->slug               = $this->generateSlug($topic,
            $inputs['title']);
        if ($userId) {
            $topic->user_id = $userId;
        }
        $topic->save();

        return $topic;
    }

    /**
     * Create a topic.
     *
     * @param  array  $inputs
     * @param  int    $user_id
     * @return void
     */
    public function store($inputs, $userId)
    {
        $topic = $this->saveTopic(new $this->model, $inputs, $userId);
        return $topic;
    }
}