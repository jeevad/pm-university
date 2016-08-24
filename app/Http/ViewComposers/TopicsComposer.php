<?php

namespace App\Http\ViewComposers;

use App\Models\Topic;
use Cache;
use Illuminate\View\View;

class TopicsComposer
{
    /**
     * Bind bachelore topics to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function bachelore(View $view)
    {
        $bacheoloreTopics = Cache::remember('bachelore_degree_topics', env('CACHE_DEFAULT_EXPIRE_TIME'), function () {
            return Topic::where('level_id', 1)->get();
        });
        $view->with([
                'bacheoloreTopics' => $bacheoloreTopics,
        ]);
    }

    /**
     * Bind master topics to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function master(View $view)
    {
        $masterTopics = Cache::remember('master_degree_topics', env('CACHE_DEFAULT_EXPIRE_TIME'), function () {
            return Topic::where('level_id', 2)->get();
        });
        $view->with([
                'masterTopics' => $masterTopics,
        ]);
    }
}
