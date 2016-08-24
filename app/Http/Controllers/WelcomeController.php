<?php

namespace App\Http\Controllers;

use App\Models\ {
    Topic
};
use App\Repositories\ {
    TopicRepository
};
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Illuminate\Http\Request.
     *
     * @var request
     */
    protected $request;

    /**
     * The TopicRepository instance.
     *
     * @var App\Repositories\TopicRepository
     */
    protected $topicGestion;

    /**
     * Set preferences.
     *
     * UsersController constructor.
     *
     * @param Request                          $request
     * @param App\Repositories\TopicRepository $topicGestion
     *
     * @return void
     */
    public function __construct(Request $request, TopicRepository $topicRepo)
    {
        // $this->middleware('auth');
        $this->request = $request;
        $this->topicGestion = $topicRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front');
    }
}
