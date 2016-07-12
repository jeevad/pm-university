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
}