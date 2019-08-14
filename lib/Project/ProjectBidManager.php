<?php
namespace Intuit\Project;

use App\Bid;
use App\Project;
use Intuit\Storage\Bid\BidRepository;
use Intuit\Storage\Database\Database;
use Intuit\Storage\Project\ProjectRepository;
use Intuit\Bid\BidType;

class ProjectBidManager
{
    /** @var Database */
    protected $database;
    /** @var ProjectRepository */
    protected $projectRepo;
    /** @var BidRepository */
    protected $bidRepo;

    public function __construct(
            Database $database,
            ProjectRepository $projectRepo,
            BidRepository $bidRepo) {
        $this->database = $database;
        $this->projectRepo = $projectRepo;
        $this->bidRepo = $bidRepo;
    }

    public function isValidType(int $type): bool {
        return in_array($type, [BidType::COST_FIXED, BidType::COST_HOURLY]);
    }

    /**
     * @param Project $project
     * @param Bid $bid
     * @return bool
     */
    public function canBid($project, $bid): bool {
        // Verifying that Bid is within Project's deadline
        $now = time();
        if ($project->status != ProjectStatus::ACTIVE || $now > $project->deadline_at) {
            return false;
        }

        // If no bid has been made yet, then current bid is valid
        if (empty($project->lowest_bid_id)) {
            return true;
        }

        $lowestBid = $this->bidRepo->find($project->lowest_bid_id);
        return $bid->getBidValue() < $lowestBid->getBidValue();
    }

    public function bid($project, $bid) {
        $bid = $this->database->transaction(function() use ($project, $bid) {
            $bid->project_id = $project->id;
            $bid->value = $bid->getBidValue(); // Making sure field is set (mainly for hourly bids)
            $this->bidRepo->save($bid);

            $project->lowest_bid_id = $bid->id;
            $this->projectRepo->save($project);

            return $bid;
        });
        return $bid;
    }
}
