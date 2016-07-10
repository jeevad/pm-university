<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Traits\ApiControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException,
    Illuminate\Database\QueryException;
use App\Repositories\LevelRepository;
use App\Http\Controllers\AppBaseController;
use Auth;
use Validator;

/**
 * @SWG\Tag(
 *      name="Admin.Level",
 *      description="Operations about Level(Bachelor's degree..)"
 * ),
 * @SWG\Definition(
 *     definition="ResponseLevelTopics",
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
 *                 @SWG\Items(ref="#/definitions/LevelTopicData")
 *             ),
 *             @SWG\Schema(
 *                 ref="#definitions/Pagination"
 *             )
 *         )
 *     }
 * ),
 * @SWG\Definition(
 *     definition="LevelTopicData",
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
 *                 @SWG\Items(ref="#/definitions/LevelTopic")
 *             )
 *          )
 *     }
 * ),
 * @SWG\Definition(
 *     definition="LevelTopic",
 *     required={"id", "title", "sourceUrl", "slug"},
 *     type="object",
 *     @SWG\Property(
 *       property="id",
 *       description="Topic id",
 *       format="int64",
 *       type="integer"
 *     ),
 *     @SWG\Property(
 *         property="title",
 *         description="Topic title",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="sourceUrl",
 *         description="Topic's source URL",
 *         type="string"
 *     ),
 *     @SWG\Property(
 *         property="slug",
 *         description="Topic slug",
 *         type="string"
 *     )
 * ),
 */
class LevelController extends AppBaseController
{

    use ApiControllerTrait;
    /**
     * Illuminate\Http\Request
     *
     * @var request
     */
    protected $request;

    /**
     * The LevelRepository instance.
     *
     * @var App\Repositories\LevelRepository
     */
    protected $levelGestion;

    /**
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Set preferences
     *
     * LevelController constructor.
     * @param Request $request
     * @param App\Repositories\LevelRepository $levelRepo
     */
    public function __construct(Request $request, LevelRepository $levelRepo)
    {
        $this->request      = $request;
        $this->levelGestion = $levelRepo;
    }

    /**
     * @param int $id
     * @return IlluminateResponse
     *
     * @SWG\Get(
     *      path="/admin/{levelId}/topics",
     *      summary="Display the topics for a specified level",
     *      tags={"Admin.Level"},
     *      description="Get the topics for a specified level id",
     *      operationId="indexTopics",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="api_token",
     *          description="Authorization token",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="levelId",
     *          description="Level id",
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
     *              ref="#/definitions/ResponseLevelTopics"
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
    public function indexTopics($levelId)
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
            $topics = $this->levelGestion->indexTopics($levelId, $perPage);

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
            return $this->respondServerError(trans('errors.something_went_wrong'));
        }
    }
}