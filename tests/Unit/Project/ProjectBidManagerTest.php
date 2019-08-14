<?php

namespace Tests\Unit\Project;

use App\Bid;
use App\Project;
use Intuit\Bid\BidType;
use Intuit\Project\ProjectBidManager;
use Intuit\Project\ProjectStatus;
use Intuit\Storage\Bid\BidRepository;
use Intuit\Storage\Database\Database;
use Intuit\Storage\Project\ProjectRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectBidManagerTest extends TestCase
{
    /** @var Database|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $database;
    /** @var ProjectRepository|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $projectRepo;
    /** @var BidRepository|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $bidRepo;
    /** @var ProjectBidManager|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $projectBidManager;

    public function setUp(): void
    {
        $this->database = \Mockery::mock(Database::class);
        $this->projectRepo = \Mockery::mock(ProjectRepository::class);
        $this->bidRepo = \Mockery::mock(BidRepository::class);

        $this->projectBidManager = new ProjectBidManager($this->database, $this->projectRepo, $this->bidRepo);
    }

    public function provider_isValidType() {
        return [
            [true, BidType::COST_FIXED],
            [true, BidType::COST_FIXED],
            [false, 0],
            [false, 3],
            [false, -1],
        ];
    }

    /** @dataProvider provider_isValidType */
    public function test_isValidType(bool $expected, int $type) {
        $this->assertEquals($expected, $this->projectBidManager->isValidType($type));
    }

    public function provider_canBid() {
        return [
            [
                false,
                [ProjectStatus::DONE, 'now'],
                [10, BidType::COST_FIXED, 10]
            ],
            [
                false,
                [ProjectStatus::ACTIVE, '-1 day'],
                [10, BidType::COST_FIXED, 10]
            ],
            [
                true,
                [ProjectStatus::ACTIVE, '+1 day'],
                [10, BidType::COST_FIXED, 10]
            ],
            [
                false,
                [ProjectStatus::ACTIVE, '+1day', [123, BidType::COST_FIXED, 10.00]],
                [555, BidType::COST_FIXED, 10.00],
            ],
            [
                false,
                [ProjectStatus::ACTIVE, '+1day', [123, BidType::COST_FIXED, 10.00]],
                [555, BidType::COST_FIXED, 10.01],
            ],
            [
                true,
                [ProjectStatus::ACTIVE, '+1day', [123, BidType::COST_FIXED, 10.00]],
                [555, BidType::COST_FIXED, 9.99],
            ],
            [
                false,
                [ProjectStatus::ACTIVE, '+1day', [123, BidType::COST_FIXED, 10.00]],
                [555, BidType::COST_HOURLY, null, 5.00, 2],
            ],
            [
                true,
                [ProjectStatus::ACTIVE, '+1day', [123, BidType::COST_FIXED, 10.00]],
                [555, BidType::COST_HOURLY, null, 4.20, 2],
            ],
        ];
    }

    /**
     * @dataProvider provider_canBid
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_canBid(bool $expected, array $projectDefinition, array $bidDefinition) {
        $project = $this->makeProject($projectDefinition);
        $bid = $this->makeBid($bidDefinition);

        $canBid = $this->projectBidManager->canBid($project, $bid);

        $this->assertEquals($expected, $canBid);

    }

    public function test_bid() {
        $this->database->shouldReceive('transaction')
            ->andReturnUsing(function($closure){
                return $closure();
            });
        $this->projectRepo->shouldReceive('save')->andReturnTrue();
//        $this->bidRepo->shouldReceive('save')->andReturnTrue();
        $this->bidRepo->shouldReceive('save')
            ->andReturnUsing(function($bid) {
                $bid->id = 123;
                return true;
            });

        $project = $this->makeProject([ProjectStatus::ACTIVE, '+1day']);
        $bid = $this->makeBid([null, BidType::COST_FIXED, 9.99]);

        $this->projectBidManager->bid($project, $bid);

        $this->assertEquals(123, $bid->id);
        $this->assertEquals(123, $project->lowest_bid_id);
    }

    private function makeProject(array $projectDefinition) {
        $project = new Project();
        $project->status = $projectDefinition[0];
        $project->deadline_at = strtotime($projectDefinition[1]);

        $lowestBid = $projectDefinition[2] ?? null;
        if (!empty($lowestBid)) {
            $bid = $this->makeBid($lowestBid);
            $project->lowest_bid_id = $bid->id;

            $this->bidRepo->shouldReceive('find')
                ->andReturn($bid);
        }

        return $project;
    }

    private function makeBid(array $bidDefinition) {
        $bid = new Bid();
        $bid->id = $bidDefinition[0];
        $bid->type = $bidDefinition[1];
        $bid->value = $bidDefinition[2] ?? null;
        $bid->hourly_value = $bidDefinition[3] ?? null;
        $bid->min_hours = $bidDefinition[4] ?? null;
        return $bid;
    }
}
