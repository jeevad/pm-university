<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\ {
	TopicRepository
};

class TopicController extends Controller {
	/**
	 * Illuminate\Http\Request
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
	 * Set preferences
	 *
	 * UsersController constructor.
	 *
	 * @param Request $request        	
	 * @param App\Repositories\TopicRepository $topicGestion        	
	 */
	public function __construct(Request $request, TopicRepository $topicRepo) {
		$this->request = $request;
		$this->topicGestion = $topicRepo;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
		$bacheoloreTopics = $this->topicGestion->index(1,200);
		$masterTopics = $this->topicGestion->index(2,200);
		return view('');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show() {
		return true;
	}
}
