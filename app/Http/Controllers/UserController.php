<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user) {
        return $user;
    }

    public function store(Request $request) {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user) {
        $user->update($request->all());
        return response()->json($user, 200);
    }
}
