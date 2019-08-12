<?php

namespace Tests\Unit\Project;

use Intuit\Bid\BidType;
use Intuit\Project\ProjectBidManager;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectBidManagerTest extends TestCase
{
    public function provider_isValidType() {
        return [
            [true, BidType::COST_FIXED],
            [true, BidType::COST_FIXED],
            [false, 0],
            [false, 3],
            [false, -1],
        ];
    }

    /**
     * @dataProvider provider_isValidType
     */
    public function test_isValidType(bool $expected, int $type) {
        $projectBidManager = new ProjectBidManager();
        $this->assertEquals($expected, $projectBidManager->isValidType($type));
    }

    public function test_canBid(bool $expected, array $projectDefinition, array $bidDefinition) {


    }
}
