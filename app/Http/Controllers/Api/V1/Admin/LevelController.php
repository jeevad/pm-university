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
}