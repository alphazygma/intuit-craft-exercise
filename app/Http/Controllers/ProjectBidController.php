<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Http\Request;

class ProjectBidController extends Controller
{
    public function index(int $projectId) {
        return Bid::where('project_id', $projectId)->get();
    }

    public function store(Request $request) {
        return Project::create($request->all());
    }
}
