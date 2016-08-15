<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use Auth;
use Validator;
use App\Models\ {
	Topic, 
	File, 
	Level, 
	Article, 
	ArticleType
};
use App\Repositories\ArticleRepository;

class ArticleController extends Controller {
	/**
	 * Illuminate\Http\Request
	 *
	 * @var request
	 */
	protected $request;
	
	/**
	 * The ArticleRepository instance.
	 *
	 * @var App\Repositories\ArticleRepository
	 */
	protected $articleGestion;
	
	/**
	 * Set preferences
	 *
	 * ArticleController constructor.
	 *
	 * @param Request $request        	
	 */
	public function __construct(Request $request, ArticleRepository $articleRepo) {
		$this->request = $request;
		$this->articleGestion = $articleRepo;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$topicId = $this->request->input ( 'topicId' );
		$articles = Article::where ( 'topic_id', $topicId )->paginate ();
		// dd($articles);
		return view ( 'back.articles.index', compact ( 'articles', 'topicId' ) );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$articleTypes = ArticleType::all ();
		$typeTitleArr = [ ];
		foreach ( $articleTypes as $articleType ) {
			$typeTitleArr [$articleType->id] = $articleType->title;
		}
		$topicId = $this->request->input ( 'topicId' );
		// dd($typeTitleArr);
		return view ( 'back.articles.create', compact ( 'articleTypes', 'typeTitleArr', 'topicId' ) );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(ArticleRequest $request) {
		$redirectUrl = 'admin/articles/create?topicId=' . $request->input ( 'topic_id' );
		$message = trans ( 'messages.something_went_wrong' );
		$level = 'danger';
		
		try {
			
			$article = $this->articleGestion->store ( $request->all (), Auth::user ()->id );
			
			flash ( trans ( 'messages.article_created_success' ), 'success' )->important ();
			return redirect ( 'admin/articles?topicId=' . $request->input ( 'topic_id' ) );
		} catch ( QueryException $e ) {
			$message .= ' ' . $e->getMessage ();
		} catch ( \ErrorException $e ) {
			$message .= ' ' . $e->getMessage ();
		}
		flash ( $message, $level )->important ();
		
		// flash ()->overlay ('Success', $message );
		return redirect ( $redirectUrl )->withInput ();
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$article = Article::findOrFail ( $id );
		$articleTypes = ArticleType::all ();
		$typeTitleArr = [ ];
		foreach ( $articleTypes as $articleType ) {
			$typeTitleArr [$articleType->id] = $articleType->title;
		}
		return view ( 'back.articles.edit', compact ( 'article', 'typeTitleArr' ) );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, ArticleRequest $request) {
		$redirectUrl = 'admin/articles/' . $id . '/edit';
		$message = trans ( 'messages.something_went_wrong' );
		$level = 'danger';
		
		try {
			$article = Article::findOrFail($id);
			$article = $this->articleGestion->saveArticle ($article, $request->all (), Auth::user ()->id );
			
			flash ( trans ( 'messages.article_created_success' ), 'success' )->important ();
			return redirect ( 'admin/articles?topicId=' . $request->input ( 'topic_id' ) );
		} catch ( QueryException $e ) {
			$message .= ' ' . $e->getMessage ();
		} catch ( \ErrorException $e ) {
			$message .= ' ' . $e->getMessage ();
		}
		flash ( $message, $level )->important ();
		
		// flash ()->overlay ('Success', $message );
		return redirect ( $redirectUrl )->withInput ();
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$message = trans ( 'messages.article_deleted_success' );
		$level = 'danger';
		$article = Article::find($id);
		try {
			
			Article::destroy ( $id );
			$level = 'success';
		} catch ( ModelNotFoundException $e ) {
			$message = trans ( 'errors.resource_not_found' );
		} catch ( QueryException $e ) {
			$message = trans ( 'errors.something_went_wrong' );
		}
		// flash()->overlay('Notice', 'You are now a Laracasts member!');
		
		flash ( $message, $level )->important ();
		// flash ()->overlay ('Success', $message );
		return redirect ( 'admin/articles?topicId='.$article->topic_id );
	}
}
