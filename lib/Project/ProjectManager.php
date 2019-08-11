<?php
namespace Intuit\Project;

use App\Project;

class ProjectManager
{
    // This should later be changed into configuration so that it can be
    // changed without deployments
    const ITEMS_PER_PAGE = 3;
    const MIN_DEADLINE_TIME = 360; // At least 1hr for a new project

    protected $projectModel;

    public function __construct(Project $projectModel) {
        $this->projectModel = $projectModel;
    }

    public function getPage(int $page) {
        if ($page < 0) {
            $page = 0;
        }

        $projects = Project::where('status', 0)
            ->orderBy('id', 'DESC')
            ->skip($page * self::ITEMS_PER_PAGE)
            ->take(self::ITEMS_PER_PAGE)
            ->get();
        return $projects;
    }

    public function isValidDeadline(int $deadlineTimestamp) {
        $current_time = time() + self::MIN_DEADLINE_TIME;
        return $deadlineTimestamp >= $current_time;
    }
}
