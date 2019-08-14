<?php
namespace Intuit\Storage\Project;

interface ProjectRepository
{
    public function all();

    public function find($id);

    public function create($input);

    public function save($entity);

}
