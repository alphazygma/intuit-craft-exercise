<?php

namespace App\Http\Controllers;

use App\Project;

use Illuminate\Http\Request;
use Intuit\Http\Response\Exception\InvalidInputException;
use Intuit\Project\ProjectManager;

class ProjectController extends Controller
{
    // This should later be changed into configuration so that it can be
    // changed without deployments
    const ITEMS_PER_PAGE = 3;

    /** @var ProjectManager  */
    protected $projectManager;

    public function __construct(ProjectManager $projectManager) {
        $this->projectManager = $projectManager;
    }

    public function index() {
        return $this->page(0);
    }

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

    public function show(Project $project) {
        return $project;
    }

    public function store(Request $request) {
        // Pull Seller ID from Authentication to make sure the project can be created

        if (!$this->isNewProjectValid($request)) {
            throw new InvalidInputException();
        }

        return Project::create($request->all());
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
