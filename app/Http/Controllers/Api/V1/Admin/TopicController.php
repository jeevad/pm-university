<?php
namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Traits\ApiControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException, Illuminate\Database\QueryException;
use App\Repositories\TopicRepository;
use App\Http\Controllers\AppBaseController;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Models\Topic, App\Models\File;
use App\Libraries\CustomImageLib;

/**
 * @SWG\Tag(
 * name="Admin.Topic",
 * description="Everything about Topics"
 * ),
 * @SWG\Definition(
 * definition="ResponseTopics",
 * required={"id"},
 * type="object",
 * allOf={
 * @SWG\Schema(
 * ref="#definitions/responseModel"
 * ),
 * @SWG\Schema(
 * required={"data"},
 * @SWG\Property(
 * property="data",
 * type="array",
 * @SWG\Items(ref="#/definitions/TopicData")
 * ),
 * @SWG\Schema(
 * ref="#definitions/Pagination"
 * )
 * )
 * }
 * ),
 * @SWG\Definition(
 * definition="TopicData",
 * required={"data"},
 * type="object",
 * allOf={
 * @SWG\Schema(
 * ref="#definitions/Pagination"
 * ),
 * @SWG\Schema(
 * required={"topics"},
 * @SWG\Property(
 * property="topics",
 * type="array",
 * @SWG\Items(ref="#/definitions/LevelTopic")
 * )
 * )
 * }
 * ),
 * @SWG\Definition(
 * definition="Topic",
 * required={"id", "title", "sourceUrl", "slug"},
 * type="object",
 * @SWG\Property(
 * property="id",
 * description="Topic id",
 * format="int64",
 * type="integer"
 * ),
 * @SWG\Property(
 * property="title",
 * description="Topic title",
 * type="string"
 * ),
 * @SWG\Property(
 * property="sourceUrl",
 * description="Topic's source URL",
 * type="string"
 * ),
 * @SWG\Property(
 * property="slug",
 * description="Topic slug",
 * type="string"
 * )
 * ),
 */
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
     *
     * @param Request $request            
     * @param App\Repositories\TopicRepository $topicGestion            
     */
    public function __construct(Request $request, TopicRepository $topicRepo)
    {
        $this->request = $request;
        $this->topicGestion = $topicRepo;
    }

    /**
     *
     * @param int $id            
     * @return IlluminateResponse @SWG\Get(
     *         path="/admin/{levelId}/topics",
     *         summary="Display the topics for a specified level",
     *         tags={"Admin.Topic"},
     *         description="Get the topics for a specified level id",
     *         operationId="indexTopics",
     *         produces={"application/json"},
     *         @SWG\Parameter(
     *         name="api_token",
     *         description="Authorization token",
     *         type="string",
     *         required=true,
     *         in="query"
     *         ),
     *         @SWG\Parameter(
     *         name="levelId",
     *         description="Level id",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         in="path"
     *         ),
     *         @SWG\Parameter(
     *         name="locale",
     *         in="query",
     *         description="User preferred language(en|hi), default en",
     *         default="en",
     *         enum={"en", "hi"},
     *         type="string"
     *         ),
     *         @SWG\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of items you would like displayed per page",
     *         default="15",
     *         type="integer",
     *         format="int64"
     *         ),
     *         @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Current page number to display",
     *         default="1",
     *         type="integer",
     *         format="int64"
     *         ),
     *         @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Schema(
     *         ref="#/definitions/ResponseTopics"
     *         )
     *         ),
     *         @SWG\Response(
     *         response=422,
     *         description="Unsuccessful operation - Validation failed",
     *         @SWG\Schema(
     *         ref="#/definitions/validationErrorModel"
     *         )
     *         ),
     *         @SWG\Response(
     *         response=404,
     *         description="Unsuccessful operation, category not found",
     *         @SWG\Schema(
     *         ref="#/definitions/responseModel"
     *         ),
     *         ),
     *         @SWG\Response(
     *         response=500,
     *         description="Unexpected error",
     *         @SWG\Schema(
     *         ref="#/definitions/responseModel"
     *         )
     *         )
     *         )
     */
    public function indexByLevel($levelId)
    {
        // Set the locale
        $locale = $this->request->has('locale') ? $this->request->input('locale') : env('APP_LOCALE');
        $inputs = array_merge($this->request->all(), [
            'levelId' => $levelId
        ]);
        $validator = Validator::make($inputs, [
            'locale' => 'sometimes|in:en,hi',
            'levelId' => 'required|exists:levels,id'
        ]);
        
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        // Set pagination
        $perPage = (int) $this->request->input('perPage', 200);
        $page = (int) $this->request->input('page', 1);
        try {
            $topics = $this->topicGestion->index($levelId, $perPage);
            $data = [
                'total' => $topics->total(),
                'currentPage' => $topics->currentPage(),
                'perPage' => $topics->perPage(),
                'hasMore' => $topics->hasMorePages(),
                'lastPage' => $topics->lastPage(),
                'nextPageUrl' => $topics->nextPageUrl() ? $topics->nextPageUrl() : '',
                'previousPageUrl' => $topics->previousPageUrl() ? $topics->previousPageUrl() : '',
                'url' => $topics->url($page)
            ];
            $data['topics'] = [];
            foreach ($topics as $topic) {
                $data['topics'][] = [
                    'id' => $topic->id,
                    'sourceUrl' => $topic->url ? $topic->url : '',
                    'title' => $topic->title ? $topic->title : '',
                    'postedOn' => $topic->created_at,
                    'slug' => $topic->slug ? url($topic->level->slug . '/' . $topic->slug) : ''
                ];
            }
            return $this->respondWithSuccess(trans('messages.success'), $data);
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), Topic::$storeTopicRules);
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        
        $topicImageId = $authorFileId = null;
        if ($this->request->hasFile('file') or $this->request->hasFile('authorPicture')) {
            $imageLib = new CustomImageLib();
        }
        // Topic image
        if ($this->request->hasFile('file')) {
            $topicImage = $this->request->file('file');
            $resizedImage = $imageLib->resize($topicImage, config('image.paths.topics'), config('image.sizes.topics'));
            if (! $resizedImage) {
                return $this->respondServerError(trans('errors.image_could_not_save_or_resize'));
            }
            $topicFile = new File();
            $topicFile->uri = config('image.paths.topics') . '/' . $resizedImage->basename;
            $topicFile->save();
            $topicImageId = $topicFile->id;
        }
        // Topic author image
        if ($this->request->hasFile('authorPicture')) {
            $authorImage = $this->request->file('authorPicture');
            $resizedImage = $imageLib->resize($authorImage, config('image.paths.authors'), config('image.sizes.authors.thumbnail'));
            if (! $resizedImage) {
                return $this->respondServerError(trans('errors.image_could_not_save_or_resize'));
            }
            $authorFile = new File();
            $authorFile->uri = config('image.paths.authors') . '/' . $resizedImage->basename;
            $authorFile->save();
            $authorFileId = $authorFile->id;
        }
        try {
            $inputs = array_merge($this->request->all(), [
                'topicImageId' => $topicImageId,
                'authorImageId' => $authorFileId
            ]);
            $topic = $this->topicGestion->store($inputs, Auth::guard(env('API_GUARD'))->user()->id);
            return $this->respondCreated(trans('back/topic.stored'), $topic->toArray());
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (\ErrorException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $inputs = array_merge($this->request->all(), [
            'topicId' => $id
        ]);
        $validator = Validator::make($inputs, array_merge(Topic::$storeTopicRules, [
            'topicId' => 'exists:topics,id'
        ]));
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        
        $topicImageId = $authorFileId = null;
        if ($this->request->hasFile('file') or $this->request->hasFile('authorPicture')) {
            $imageLib = new CustomImageLib();
        }
        // Topic image
        if ($this->request->hasFile('file')) {
            $topicImage = $this->request->file('file');
            $resizedImage = $imageLib->resize($topicImage, config('image.paths.topics'), config('image.sizes.topics'));
            if (! $resizedImage) {
                return $this->respondServerError(trans('errors.image_could_not_save_or_resize'));
            }
            $topicFile = new File();
            $topicFile->uri = config('image.paths.topics') . '/' . $resizedImage->basename;
            $topicFile->save();
            $topicImageId = $topicFile->id;
        }
        // Topic author image
        if ($this->request->hasFile('authorPicture')) {
            $authorImage = $this->request->file('authorPicture');
            $resizedImage = $imageLib->resize($authorImage, config('image.paths.authors'), config('image.sizes.authors.thumbnail'));
            if (! $resizedImage) {
                return $this->respondServerError(trans('errors.image_could_not_save_or_resize'));
            }
            $authorFile = new File();
            $authorFile->uri = config('image.paths.authors') . '/' . $resizedImage->basename;
            $authorFile->save();
            $authorFileId = $authorFile->id;
        }
        try {
            $inputs = array_merge($this->request->all(), [
                'topicImageId' => $topicImageId,
                'authorImageId' => $authorFileId
            ]);
            $topicModel = $this->topicGestion->getById($id);
            $topic = $this->topicGestion->saveTopic($topicModel, $inputs, 1);
            return $this->respondWithSuccess(trans('back/topic.updated'), $topic->toArray());
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (\ErrorException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound(trans('errors.resource_not_found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locale = $this->request->has('locale') ? $this->request->input('locale') : env('APP_LOCALE');
        $inputs = array_merge($this->request->all(), [
            'topicId' => $id
        ]);
        $validator = Validator::make($inputs, [
            'locale' => 'sometimes|in:en,hi',
            'topicId' => 'required|exists:topics,id'
        ]);
        
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        try {
            $result = $this->topicGestion->show($id);
            
            $topic = $result['topic'];
            $topic->sourceUrl = $topic->sourceUrl ? $topic->sourceUrl : '';
            $topic->description = $topic->description ? $topic->description : '';
            $topic->authorName = $topic->authorName ? $topic->authorName : '';
            $topic->authorDesc = $topic->authorDesc ? $topic->authorDesc : '';
            $topic->topicImgUri = $topic->topicImgUri ? url($topic->topicImgUri) : '';
            $topic->authorImgUri = $topic->authorImgUri ? url($topic->authorImgUri) : '';
            $data = [
                'topic' => $topic,
                'comments' => $result['comments']
            ];
            
            return $this->respondWithSuccess(trans('messages.success'), $data);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound(trans('errors.resource_not_found'));
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Topic::destroy($id);
            return $this->respondWithSuccess(trans('messages.success'));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound(trans('errors.resource_not_found'));
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }
}