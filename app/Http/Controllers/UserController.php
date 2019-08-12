<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="show",
     *      tags={"Users"},
     *      summary="Get User information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          @OA\Schema(type="integer"), required=true, in="path",
     *          description="User id",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param User $project
     * @return User
     */
    public function show(User $user) {
        return $user;
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="store",
     *      tags={"Users"},
     *      summary="Create a new User",
     *      description="Returns saved user data",
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Invalid Input"),
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * @OA\Patch(
     *      path="/users/{id}",
     *      operationId="update",
     *      tags={"Users"},
     *      summary="Updates an existing User",
     *      description="Updates an existing User data only for the elements suplied",
     *      @OA\Parameter(
     *          name="id",
     *          @OA\Schema(type="integer"), required=true, in="path",
     *          description="User id",
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=400, description="Invalid Input"),
     * )
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user) {
        $user->update($request->all());
        return response()->json($user, 200);
    }
}
