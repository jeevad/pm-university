<?php

namespace App\Repositories;

use App\Models\Topic,
    App\Models\Level;
use DB;

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
    public function index($levelId, $perPage)
    {
        $query = $this->model
            ->with('level')
            ->where('level_id', $levelId)
            ->whereNull('topics.deleted_at')
            ->latest();

        return $query->paginate($perPage);
    }

    /**
     * Get topic collection.
     *
     * @param  string  $slug
     * @return array
     */
    public function show($id)
    {
        $topic = DB::table('topics as topic')
            ->leftJoin('files as file', 'file.id', '=', 'topic.file_id')
            ->leftJoin('files as authorImg', 'authorImg.id', '=',
                'topic.author_picture_id')
            ->select('topic.id', 'topic.url as sourceUrl', 'topic.title',
                'topic.description', 'topic.id', 'file.uri as topicImgUri',
                'topic.author_name as authorName',
                'topic.author_description as authorDesc',
                'authorImg.uri as authorImgUri', 'topic.created_at as postedOn')
            ->where('topic.id', $id)
            ->first();

//        $comments = $this->comment
//            ->wherePost_id($post->id)
//            ->with('user')
//            ->whereHas('user',
//                function($q) {
//                $q->whereValid(true);
//            })
//            ->get();
        $comments = [];

        return compact('topic', 'comments');
    }

    /**
     * Create or update a topic.
     *
     * @param  App\Models\Topic $topic
     * @param  array  $inputs
     * @param  bool   $user_id
     * @return App\Models\Topic
     */
    public function saveTopic($topic, $inputs, $userId = null)
    {
        $topic->level_id           = (int) $inputs['levelId'];
        $topic->url                = strtolower($inputs['sourceUrl']);
        $topic->title              = ucwords(strtolower($inputs['title']));
        $topic->description        = ucwords($inputs['description']);
        $topic->file_id            = $inputs['topicImageId'];
        $topic->author_name        = isset($inputs['authorName']) ? ucwords(strtolower($inputs['authorName']))
                : null;
        $topic->author_description = isset($inputs['authorDescription']) ? ucwords(strtolower($inputs['authorDescription']))
                : null;
        $topic->author_picture_id  = $inputs['authorImageId'];
        $topic->h1                 = isset($inputs['h1']) ? ucfirst($inputs['h1'])
                : null;
        $topic->meta_title         = isset($inputs['metaTitle']) ? $inputs['metaTitle']
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