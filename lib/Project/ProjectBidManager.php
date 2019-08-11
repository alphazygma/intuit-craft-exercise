<?php
namespace Intuit\Project;

use App\Bid;
use App\Project;
use Intuit\Bid\BidType;

class ProjectBidManager
{
    public function isValidType(int $type): bool {
        return in_array($type, [BidType::COST_FIXED, BidType::COST_HOURLY]);
    }

    public function canBid(Project $project, Bid $bid): bool {
        // Verifying that Bid is within Project's deadline
        $now = time();
        if ($project->status != ProjectStatus::ACTIVE || $now > $project->deadline_at) {
            return false;
        }

        // If no bid has been made yet, then current bid is valid
        if (empty($project->lowest_bid_id)) {
            return true;
        }

        $lowestBid = Bid::find($project->lowest_bid_id);
        return $bid->getBidValue() < $lowestBid->getBidValue();
    }

    public function bid(Project $project, Bid $bid): Bid {
        $bid = \DB::transaction(function() use ($project, $bid) {
            $bid->project_id = $project->id;
            $bid->value = $bid->getBidValue(); // Making sure field is set (mainly for hourly bids)
            $bid->save();

            $project->lowest_bid_id = $bid->id;
            $project->save();

            return $bid;
        });
        return $bid;
    }
}
