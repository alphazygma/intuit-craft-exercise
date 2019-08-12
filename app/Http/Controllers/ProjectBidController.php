<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Project;
use Illuminate\Http\Request;
use Intuit\Bid\BidType;
use Intuit\Bid\Exception\LowerBidNotMetException;
use Intuit\Http\Response\Exception\InvalidInputException;
use Intuit\Project\Exception\ExpiredProjectException;
use Intuit\Project\ProjectBidManager;

class ProjectBidController extends Controller
{
    /** @var ProjectBidManager */
    private $projectBidManager;

    public function __construct(ProjectBidManager $projectBidManager) {
        $this->projectBidManager = $projectBidManager;
    }

    /**
     * @OA\Get(
     *      path="/project/{project_id}/bids",
     *      operationId="show",
     *      tags={"Bids"},
     *      summary="Get all Project's bids",
     *      description="Returns all bids from a given project",
     *      @OA\Parameter(
     *          name="project_id",
     *          @OA\Schema(type="integer"), required=true, in="path",
     *          description="Project id",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param int $projectId
     * @return mixed
     */
    public function index(int $projectId) {
        return Bid::where('project_id', $projectId)->get();
    }

    /**
     * @OA\Post(
     *      path="/project/{project_id}/bids",
     *      operationId="store",
     *      tags={"Bids"},
     *      summary="Adds a bid on an existing project",
     *      description="Adds a bid to an existing project if valid and updates the project appropriately",
     *      @OA\Parameter(
     *          name="project_id",
     *          @OA\Schema(type="integer"), required=true, in="path",
     *          description="Project id",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not Found|Invalid Input|Project is expired"),
     * )
     *
     * @param int $projectId
     * @return mixed
     */
    public function store(Request $request, Project $project) {
        $this->validateBid($request, $project);

        $bid = new Bid();
        $bid->fill($request->all());
        $bid = $this->projectBidManager->bid($project,$bid);

        return $bid;
    }

    private function validateBid(Request $request,  Project $project) {
        $input = $request->all();

        $validator = \Validator::make($input, ['type' => 'required|integer']);
        if ($validator->fails() || !$this->projectBidManager->isValidType($input['type'])) {
            throw new InvalidInputException();
        }

        if ($input['type'] == BidType::COST_FIXED) {
            $type_rules = ['value' => 'required|numeric|min:0'];

        } else { // $input['type'] == BidType::COST_HOURLY
            $type_rules = [
                'hourly_value' => 'required|numeric|min:0',
                'min_hours' => 'required|integer|min:1',
            ];
        }
        $validator = \Validator::make($input, $type_rules);
        if ($validator->fails()) {
            throw new InvalidInputException();
        }

        $bid = new Bid();
        $bid->fill($input);

        if (!$this->projectBidManager->canBid($project, $bid)) {
            $now = time();
            if ($now > $project->deadline_at) {
                throw new ExpiredProjectException();
            }

            throw new LowerBidNotMetException();
        }
    }
}
