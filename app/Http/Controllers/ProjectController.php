<?php

namespace App\Http\Controllers;

use App\Project;

use Illuminate\Http\Request;
use Intuit\Http\Response\Exception\InvalidInputException;
use Intuit\Project\ProjectManager;
use Intuit\Storage\Project\ProjectRepository;

class ProjectController extends Controller
{
    // This should later be changed into configuration so that it can be
    // changed without deployments
    const ITEMS_PER_PAGE = 3;

    /** @var ProjectManager  */
    protected $projectManager;
    /** @var ProjectRepository */
    protected $projectRepo;

    public function __construct(ProjectManager $projectManager, ProjectRepository $projectRepo) {
        $this->projectManager = $projectManager;
        $this->projectRepo = $projectRepo;
    }

    /**
     * @OA\Get(
     *      path="/projects",
     *      operationId="index",
     *      tags={"Projects"},
     *      summary="Get list of projects",
     *      description="Returns list of projects",
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Invalid Input")
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return $this->page(0);
    }

    /**
     * @OA\Get(
     *      path="/projects/page/{page}",
     *      operationId="page",
     *      tags={"Projects"},
     *      summary="Get a list of projects",
     *      description="Returns list of projects for the supplied page",
     *      @OA\Parameter(
     *          name="page",
     *          @OA\Schema(type="integer"), required=true, in="path",
     *          description="Page required for list of projects",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     * )
     *
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function page(int $page) {
        $project_list = $this->projectManager->getPage($page);

        $response = [
            'data'     => $project_list,
            'next'     => action([static::class, 'page'], ['page' => $page + 1]),
            'previous' => null,
        ];

        if ($page > 0) {
            $response['previous'] = action([static::class, 'page'], ['page' => $page-1]);
        }

        return response()->json($response);
    }

    /**
     * @OA\Get(
     *      path="/projects/{id}",
     *      operationId="show",
     *      tags={"Projects"},
     *      summary="Get project information",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="project_id",
     *          @OA\Schema(type="integer"),
     *          required=true,
     *          in="path",
     *          description="Project id",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Invalid Input"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param Project $project
     * @return Project
     */
    public function show(Project $project) {
        return $project;
    }

    /**
     * @OA\Post(
     *      path="/projects",
     *      operationId="store",
     *      tags={"Projects"},
     *      summary="Create a new project",
     *      description="Creates a new project with the supplied definition, for the authenticated seller",
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Invalid Input"),
     * )
     *
     * @param Request $request
     * @return Project
     */
    public function store(Request $request) {
        // Pull Seller ID from Authentication to make sure the project can be created

        if (!$this->isNewProjectValid($request)) {
            throw new InvalidInputException();
        }

        return $this->projectRepo->create($request->all());
    }

    private function isNewProjectValid(Request $request) {
        $input = $request->all();

        $input['title']       = filter_var($input['title'],       FILTER_SANITIZE_STRING);
        $input['description'] = filter_var($input['description'], FILTER_SANITIZE_STRING);

        $request->replace($input);

        $validator = \Validator::make($input, [
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'deadline_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return false;
        }

        $deadline = strtotime($request->input('deadline_at'));
        if (!$this->projectManager->isValidDeadline($deadline)) {
            return false;
        }

        return true;
    }
}
