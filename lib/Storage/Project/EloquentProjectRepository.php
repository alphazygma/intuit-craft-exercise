<?php
namespace Intuit\Storage\Project;

use App\Project;

class EloquentProjectRepository implements ProjectRepository
{
    public function all() {
        return Project::all();
    }

    public function find($id) {
        return Project::find($id);
    }

    public function create($input) {
        return Project::create($input);
    }

    public function save($entity) {
        return $entity->save();
    }
}
