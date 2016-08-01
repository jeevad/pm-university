<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository,
    App\Repositories\UserRepository;
use Validator;
use App\Http\Controllers\AppBaseController;
use App\Traits\ApiControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException,
    Illuminate\Database\QueryException;
use App\Models\Article;

/**
 * @SWG\Tag(
 *      name="Article",
 *      description="Everything about Articles"
 * ),
 * @SWG\Definition(
 *     definition="ResponseArticles",
 *     required={"id"},
 *     type="object",
 *     allOf={
 *         @SWG\Schema(
 *             ref="#definitions/responseModel"
 *         ),
 *         @SWG\Schema(
 *             required={"data"},
 *             @SWG\Property(
 *                 property="data",
 *                 type="array",
 *                 @SWG\Items(ref="#/definitions/ArticleData")
 *             ),
 *             @SWG\Schema(
 *                 ref="#definitions/Pagination"
 *             )
 *         )
 *     }
 * ),
 * @SWG\Definition(
 *     definition="ArticleData",
 *     required={"data"},
 *     type="object",
 *     allOf={
 *          @SWG\Schema(
 *             ref="#definitions/Pagination"
 *         ),
 *          @SWG\Schema(
 *              required={"topics"},
 *              @SWG\Property(
 *                 property="topics",
 *                 type="array",
 *                 @SWG\Items(ref="#/definitions/Article")
 *             )
 *          )
 *     }
 * ),
 * @SWG\Definition(
 *     definition="Article",
 *     required={"id", "title", "sourceUrl", "slug"},
 *     type="object",
 *     @SWG\Property(
 *       property="id",
 *       description="Article id",
 *       format="int64",
 *       type="integer"
 *     ),
 *     @SWG\Property(
 *         property="title",
 *         description="Article title",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="sourceUrl",
 *         description="Article's source URL",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="slug",
 *         description="Article's slug",
 *         type="string"
 *     )
 * ),
 */
class ArticleController extends AppBaseController
{

    use ApiControllerTrait;
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
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Create a new ContentController instance.
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Repositories\TopicRepository $topicRepo
     * @return void
     */
    public function __construct(
    Request $request, ArticleRepository $artilceRepo)
    {
        $this->request        = $request;
        $this->articleGestion = $artilceRepo;
        $this->nbrPages       = 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $topics = $this->topicGestion->index(
                10,
                $this->request->has('levelId') ? $this->request->input('levelId')
                        : 1);
            dd(compact('topics'));
        } catch (QueryException $e) {
            echo 'some thing went wrong'.$e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(),
                Article::$storeArticleRules);
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }

        $authorFileId = null;

        // Article author image
        if ($this->request->hasFile('authorPicture')) {
            $authorImage  = $this->request->file('authorPicture');
            $resizedImage = $imageLib->resize($authorImage,
                config('image.paths.authors'),
                config('image.sizes.authors.thumbnail'));
            if (!$resizedImage) {
                return $this->respondServerError(trans('errors.image_could_not_save_or_resize'));
            }
            $authorFile      = new File();
            $authorFile->uri = config('image.paths.authors').'/'.$resizedImage->basename;
            $authorFile->save();
            $authorFileId    = $authorFile->id;
        }
        try {
            $inputs  = array_merge($this->request->all(),
                ['authorImageId' => $authorFileId]);
            $article = $this->articleGestion->store($inputs, 1);
            return $this->respondCreated(trans('back/article.stored'),
                    $article->toArray());
        } catch (QueryException $e) {
            echo $e->getMessage();
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (\ErrorException $e) {
            echo $e->getMessage();
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $content = $this->contentGestion->show($slug);

            //foreach($contents as $content) {
            dump($content->tags->title);
            // }
            exit;
            // dump($content->tags->count());
            dd(compact('content'));
        } catch (QueryException $e) {
            echo 'some thing went wrong'.$e->getMessage();
        }
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

    /**
     * @param int $topicId
     * @param int $tagId
     * @return IlluminateResponse
     *
     * @SWG\Get(
     *      path="/admin/topic/{topicId}/tag/{tagId}",
     *      summary="Display the articles for a specified tag",
     *      tags={"Article"},
     *      description="Get the articles for a specified tag",
     *      operationId="indexByTag",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="api_token",
     *          description="Authorization token",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="topicId",
     *          description="Topic id",
     *          type="integer",
     *          format="int32",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="tagId",
     *          description="Tag id",
     *          type="integer",
     *          format="int32",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="locale",
     *          in="query",
     *          description="User preferred language(en|hi), default en",
     *          default="en",
     *          enum={"en", "hi"},
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="perPage",
     *          in="query",
     *          description="Number of items you would like displayed per page",
     *          default="15",
     *          type="integer",
     *          format="int64"
     *      ),
     *      @SWG\Parameter(
     *          name="page",
     *          in="query",
     *          description="Current page number to display",
     *          default="1",
     *          type="integer",
     *          format="int64"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Successful operation",
     *          @SWG\Schema(
     *              ref="#/definitions/ResponseArticles"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="Unsuccessful operation - Validation failed",
     *          @SWG\Schema(
     *              ref="#/definitions/validationErrorModel"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Unsuccessful operation, category not found",
     *          @SWG\Schema(
     *              ref="#/definitions/responseModel"
     *          ),
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="Unexpected error",
     *          @SWG\Schema(
     *              ref="#/definitions/responseModel"
     *          )
     *      )
     * )
     */
    public function indexByTag($topicId, $tagId)
    {
        // Set the locale
        $locale    = $this->request->has('locale') ? $this->request->input('locale')
                : env('APP_LOCALE');
        $inputs    = array_merge($this->request->all(),
            ['topicId' => $topicId, 'tagId' => $tagId]);
        $validator = Validator::make($inputs,
                [
                'locale' => 'sometimes|in:en,hi',
                'tagId' => 'required|exists:tags,id',
                'topicId' => 'required|exists:topics,id'
        ]);

        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        // Set pagination
        $perPage = (int) $this->request->input('perPage', 200);
        $page    = (int) $this->request->input('page', 1);
        try {
            $articles         = $this->contentGestion->indexTag($perPage,
                $topicId, $tagId);
            $data             = [
                'total' => $articles->total(),
                'currentPage' => $articles->currentPage(),
                'perPage' => $articles->perPage(),
                'hasMore' => $articles->hasMorePages(),
                'lastPage' => $articles->lastPage(),
                'nextPageUrl' => $articles->nextPageUrl() ? $articles->nextPageUrl()
                        : '',
                'previousPageUrl' => $articles->previousPageUrl() ? $articles->previousPageUrl()
                        : '',
                'url' => $articles->url($page)
            ];
            $data['articles'] = [];
            foreach ($articles as $article) {
                $data['articles'][] = [
                    'id' => $article->id,
                    'sourceUrl' => $article->url ? $article->url : '',
                    'title' => $article->title ? $article->title : '',
                    'slug' => $article->slug ? url($article->slug) : '',
                ];
            }
            return $this->respondWithSuccess(trans('messages.success'), $data);
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }
}