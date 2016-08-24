<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\ File;
use App\Models\ Level;
use App\Models\ Topic;
use App\Repositories\TopicRepository;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;

class TopicController extends Controller
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
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Set preferences.
     *
     * UsersController constructor.
     *
     * @param Request                          $request
     * @param App\Repositories\TopicRepository $topicGestion
     */
    public function __construct(Request $request, TopicRepository $topicRepo)
    {
        $this->request = $request;
        $this->topicGestion = $topicRepo;
    }

    public function index()
    {
        $topics = Topic::with('level')->orderBy('created_at', 'desc')->paginate();

        return view('back.topics.index', [
                'topics' => $topics,
        ]);
    }

    public function create()
    {
        return view('back.topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $redirectUrl = 'admin/topics/create';
        $message = trans('messages.something_went_wrong');
        $level = 'danger';

        try {
            $topic = $this->topicGestion->store($request->all(), Auth::user()->id);

            flash(trans('messages.topic_created_success'), 'success')->important();

            return redirect('admin/topics');
        } catch (QueryException $e) {
            $message .= ' '.$e->getMessage();
        } catch (\ErrorException $e) {
            $message .= ' '.$e->getMessage();
        }
        flash($message, $level)->important();

        // flash ()->overlay ('Success', $message );
        return redirect($redirectUrl)->withInput();
    }

    public function edit($id)
    {
        $topic = Topic::findOrFail($id);

        return view('back.topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, TopicRequest $request)
    {
        $redirectUrl = 'admin/topics/'.$id.'/edit';

        $level = 'danger';

        $topicImageId = $authorFileId = null;
        if ($request->hasFile('file') or $request->hasFile('authorPicture')) {
            $imageLib = new CustomImageLib();
        }
        // Topic image
        if ($request->hasFile('file')) {
            $topicImage = $request->file('file');
            $resizedImage = $imageLib->resize($topicImage, config('image.paths.topics'), config('image.sizes.topics'));
            if (!$resizedImage) {
                $message = trans('errors.image_could_not_save_or_resize');
                flash($message, $level)->important();

                return redirect($redirectUrl)->withInput();
            }
            $topicFile = new File();
            $topicFile->uri = config('image.paths.topics').'/'.$resizedImage->basename;
            $topicFile->save();
            $topicImageId = $topicFile->id;
        }
        // Topic author image
        if ($request->hasFile('author_picture')) {
            $authorImage = $request->file('author_picture');
            $resizedImage = $imageLib->resize($authorImage, config('image.paths.authors'), config('image.sizes.authors.thumbnail'));
            if (!$resizedImage) {
                $message = trans('errors.image_could_not_save_or_resize');
                flash($message, $level)->important();

                return redirect($redirectUrl)->withInput();
            }
            $authorFile = new File();
            $authorFile->uri = config('image.paths.authors').'/'.$resizedImage->basename;
            $authorFile->save();
            $authorFileId = $authorFile->id;
        }
        try {
            $inputs = array_merge($request->all(), [
                    'topicImageId'  => $topicImageId,
                    'authorImageId' => $authorFileId,
            ]);
            $topicModel = $this->topicGestion->getById($id);
            $topic = $this->topicGestion->saveTopic($topicModel, $request->all(), 1);

            flash(trans('messages.topic_updated_success'), 'success')->important();

            return redirect('admin/topics');
        } catch (QueryException $e) {
            $message = trans('errors.something_went_wrong').$e->getMessage();
        } catch (\ErrorException $e) {
            $message = trans('errors.something_went_wrong').$e->getMessage();
        } catch (ModelNotFoundException $e) {
            $message = trans('errors.something_went_wrong').$e->getMessage();
        }
        flash($message, $level)->important();

        return redirect($redirectUrl)->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locale = $this->request->has('locale') ? $this->request->input('locale') : env('APP_LOCALE');
        $inputs = array_merge($this->request->all(), [
                'topicId' => $id,
        ]);
        $validator = Validator::make($inputs, [
                'locale'  => 'sometimes|in:en,hi',
                'topicId' => 'required|exists:topics,id',
        ]);

        if ($validator->fails()) {
            $errors = formatValidationMessages($validator->errors());

            return $this->respondWithValidationError($errors);
        }
        try {
            $result = $this->topicGestion->show($id);

            $topic = $result ['topic'];
            $topic->sourceUrl = $topic->sourceUrl ? $topic->sourceUrl : '';
            $topic->description = $topic->description ? $topic->description : '';
            $topic->authorName = $topic->authorName ? $topic->authorName : '';
            $topic->authorDesc = $topic->authorDesc ? $topic->authorDesc : '';
            $topic->topicImgUri = $topic->topicImgUri ? url($topic->topicImgUri) : '';
            $topic->authorImgUri = $topic->authorImgUri ? url($topic->authorImgUri) : '';
            $data = [
                    'topic'    => $topic,
                    'comments' => $result ['comments'],
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = trans('messages.topic_deleted_success');
        $level = 'danger';
        try {
            Topic::destroy($id);
            $level = 'success';
        } catch (ModelNotFoundException $e) {
            $message = trans('errors.resource_not_found');
        } catch (QueryException $e) {
            $message = trans('errors.something_went_wrong');
        }
        // flash()->overlay('Notice', 'You are now a Laracasts member!');

        flash($message, $level)->important();
        // flash ()->overlay ('Success', $message );
        return redirect('admin/topics');
    }

    /**
     * @param unknown $type
     */
    public function indexByLevel($type)
    {
        $msgLevel = 'danger';
        try {
            $level = Level::whereSlug($type)->firstOrFail();
            $topics = Topic::with('level')->where('level_id', $level->id)->orderBy('created_at', 'desc')->paginate();

            return view('back.topics.index', compact('topics'));
        } catch (ModelNotFoundException $e) {
            flash(trans('errors.invalid_product_type'), $msgLevel)->important();

            return back();
        } catch (QueryException $e) {
            flash(trans('errors.something_went_wrong'), $msgLevel)->important();

            return back();
        }
    }
}
