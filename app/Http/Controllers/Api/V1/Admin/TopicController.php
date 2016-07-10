<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Traits\ApiControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException,
    Illuminate\Database\QueryException;
use App\Repositories\TopicRepository;
use App\Http\Controllers\AppBaseController;
use Auth;
use Validator;


class TopicController extends AppBaseController
{

    use ApiControllerTrait;
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
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Set preferences
     *
     * UsersController constructor.
     * @param Request $request
     * @param App\Repositories\TopicRepository $topicGestion
     */
    public function __construct(Request $request, TopicRepository $topicRepo)
    {
        $this->request      = $request;
        $this->topicGestion = $topicRepo;
    }

    public function indexByLevel($levelId)
    {
        // Set the locale
        $locale    = $this->request->has('locale') ? $this->request->input('locale')
                : env('APP_LOCALE');
        $inputs    = array_merge($this->request->all(), ['levelId' => $levelId]);
        $validator = Validator::make($inputs,
                [
                'locale' => 'sometimes|in:en,hi',
                'levelId' => 'required|exists:levels,id'
        ]);

        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        // Set pagination
        $perPage = (int) $this->request->input('perPage', 200);
        $page    = (int) $this->request->input('page', 1);
        try {
            $topics = $this->topicGestion->index(
                $perPage, $levelId);

            $data           = [
                'total' => $topics->total(),
                'currentPage' => $topics->currentPage(),
                'perPage' => $topics->perPage(),
                'hasMore' => $topics->hasMorePages(),
                'lastPage' => $topics->lastPage(),
                'nextPageUrl' => $topics->nextPageUrl() ? $topics->nextPageUrl()
                        : '',
                'previousPageUrl' => $topics->previousPageUrl() ? $topics->previousPageUrl()
                        : '',
                'url' => $topics->url($page)
            ];
            $data['topics'] = [];
            foreach ($topics as $topic) {
                $data['topics'][] = [
                    'id' => $topic->id,
                    'sourceUrl' => $topic->url ? $topic->url : '',
                    'title' => $topic->title ? $topic->title : '',
                    'slug' => $topic->slug ? url($topic->level->slug.'/'.$topic->slug)
                            : '',
                ];
            }
            return $this->respondWithSuccess(trans('messages.success'), $data);
        } catch (QueryException $e) {
            dump($e->getMessage());
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}