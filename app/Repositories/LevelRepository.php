<?php

namespace App\Repositories;

use App\Models\Topic,
    App\Models\Level;

class LevelRepository extends BaseRepository
{
    /**
     * The Topic instance.
     *
     * @var App\Models\Topic
     */
    protected $topic;

    /**
     * Create a new LevelRepository instance.
     *
     * @param  App\Models\Level $level
     * * @param  App\Models\Topic $topic
     * @return void
     */
    public function __construct(
    Level $level, Topic $topic)
    {
        $this->model = $level;
        $this->topic = $topic;
    }

    /**
     * Get topic collection by level.
     *
     * @param  int     $levelId
     * @param  int     $perPage
     * @return Illuminate\Support\Collection
     */
    public function indexTopics($levelId, $perPage)
    {
        $model = 'topic';
        $query = $this->{$model}
            ->with('level')
            ->where('level_id', $levelId)
            ->whereNull('topics.deleted_at')
            ->latest();

        return $query->paginate($perPage);
    }
}