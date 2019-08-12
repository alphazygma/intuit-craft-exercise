<?php

/**
 * @OA\Get(
 *      path="/sellers/{id}",
 *      operationId="show",
 *      tags={"Sellers"},
 *      summary="Get seller information",
 *      description="Returns seller data",
 *      @OA\Parameter(
 *          name="id",
 *          @OA\Schema(type="integer"), required=true, in="path",
 *          description="Project id",
 *      ),
 *      @OA\Response(response=200, description="successful operation"),
 *      @OA\Response(response=400, description="Invalid Input"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 * )
 *
 * @OA\Post(
 *      path="/sellers",
 *      operationId="store",
 *      tags={"Sellers"},
 *      summary="Add a new seller",
 *      description="Registers the current user as a seller",
 *      @OA\Response(response=200, description="successful operation"),
 *      @OA\Response(response=400, description="Invalid Input"),
 * )
 *
 * @OA\Get(
 *      path="/buyers/{id}",
 *      operationId="show",
 *      tags={"Buyers"},
 *      summary="Get buyer information",
 *      description="Returns buyer data",
 *      @OA\Parameter(
 *          name="id",
 *          @OA\Schema(type="integer"), required=true, in="path",
 *          description="Project id",
 *      ),
 *      @OA\Response(response=200, description="successful operation"),
 *      @OA\Response(response=400, description="Invalid Input"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 * )
 *
 * @OA\Post(
 *      path="/buyers",
 *      operationId="store",
 *      tags={"Buyers"},
 *      summary="Add a new Buyer",
 *      description="Registers the current user as a buyer",
 *      @OA\Response(response=200, description="successful operation"),
 *      @OA\Response(response=400, description="Invalid Input"),
 * )
 *
 *
 */
