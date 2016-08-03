<?php
namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Repositories\ {
                ArticleRepository
};
use Validator;
use App\Http\Controllers\AppBaseController;
use App\Traits\ApiControllerTrait;
use Illuminate\Database\QueryException;
use App\Models\Article;

/**
 * @SWG\Tag(
 * name="Article",
 * description="Everything about Articles"
 * ),
 * @SWG\Definition(
 * definition="ResponseArticles",
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
 * @SWG\Items(ref="#/definitions/ArticleData")
 * ),
 * @SWG\Schema(
 * ref="#definitions/Pagination"
 * )
 * )
 * }
 * ),
 * @SWG\Definition(
 * definition="ArticleData",
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
 * @SWG\Items(ref="#/definitions/Article")
 * )
 * )
 * }
 * ),
 * @SWG\Definition(
 * definition="Article",
 * required={"id", "title", "sourceUrl", "slug"},
 * type="object",
 * @SWG\Property(
 * property="id",
 * description="Article id",
 * format="int64",
 * type="integer"
 * ),
 * @SWG\Property(
 * property="title",
 * description="Article title",
 * type="string"
 * ),
 * @SWG\Property(
 * property="sourceUrl",
 * description="Article's source URL",
 * type="string"
 * ),
 * @SWG\Property(
 * property="slug",
 * description="Article's slug",
 * type="string"
 * )
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
     * @param Illuminate\Http\Request $request            
     * @param App\Repositories\TopicRepository $topicRepo            
     * @return void
     */
    public function __construct(Request $request, ArticleRepository $artilceRepo)
    {
        $this->request = $request;
        $this->articleGestion = $artilceRepo;
        $this->nbrPages = 10;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set the locale
        $locale = $this->request->has('locale') ? $this->request->input('locale') : env('APP_LOCALE');
        
        $validator = Validator::make($this->request->all(), [
            'locale' => 'sometimes|in:en,hi',
            'topicId' => 'required|exists:topics,id',
            'typeId' => 'sometimes|exists:article_types,id'
        ]);
        
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        // Set pagination
        $perPage = (int) $this->request->input('perPage', 10);
        $page = (int) $this->request->input('page', 1);
        try {
            $articles = $this->articleGestion->index($perPage, (int) $this->request->input('topicId'), $this->request->has('typeId') ? (int) $this->request->input('typeId') : 1);
            return $this->respondWithSuccess(trans('messages.success'), $articles->toArray());
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request            
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make($this->request->all(), Article::$storeArticleRules);
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
        
        $authorFileId = null;
        
        // Article author image
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
                'authorImageId' => $authorFileId
            ]);
            $article = $this->articleGestion->store($inputs, 1);
            return $this->respondCreated(trans('back/article.stored'), $article->toArray());
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
            'articleId' => $id
        ]);
        $validator = Validator::make($inputs, array_merge(Article::$storeArticleRules, [
            'articleId' => 'exists:articles,id'
        ]));
        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());
            return $this->respondWithValidationError($errors);
        }
    
        $authorFileId = null;
        
        // Article author image
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
                'authorImageId' => $authorFileId
            ]);
            $articleModel = $this->articleGestion->getById($id);
            $article = $this->articleGestion->saveArticle($articleModel, $inputs, 1);
            return $this->respondWithSuccess(trans('back/article.updated'), $article->toArray());
        } catch (QueryException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (\ErrorException $e) {
            return $this->respondServerError(trans('errors.something_went_wrong'));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound(trans('errors.resource_not_found'));
        }
    }
}