<?php

namespace App\Http\Controllers;

use App\Models\DeeDee;
use App\Http\Requests\StoreDeeDeeRequest;
use App\Http\Requests\UpdateDeeDeeRequest;
use GuzzleHttp\Promise\Promise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use OpenApi\Annotations as OA;


class DeeDeeController extends Controller
{



    /**
     * @OA\Get(
     *     path="/api/deedee",
     *     tags={"characters"},
     *     summary="Returns a paginated collection of deedees",
     *     description="Returns stuff",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\AdditionalProperties(
     *                 type="integer",
     *                 format="int32"
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(\App\Models\DeeDee::paginate(15));
    }

   


    /**
     * @OA\Post(
     *     path="/api/deedee",
     *     tags={"characters"},
     *     summary="Create A New Deedee",
     *     operationId="store",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DeeDee"),
     *         @OA\XmlContent(ref="#/components/schemas/DeeDee")
     *     ),
     *     @OA\RequestBody(
     *         description="creating a dee dee",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DeeDee")
     *     )
     * )
     */
    public function store(StoreDeeDeeRequest $request)
    {
        /**
         * The $request->safe() is a short hand way to call to \Illuminate\Contracts\Validation\Validator::validate(), 
         * Which is a provided by the App\Http\Requests\StoreDeeDeeRequest\StoreDeeDeeRequest
         */
        $deedee = DeeDee::create($request->safe()->all());

        return response()->json($deedee); 
    }

    /**
     * @OA\Get(
     *     path="/api/deedee/{deedeeId}",
     *     tags={"characters"},
     *     description="integer id of deedee entities",
     *     operationId="getOrderById",
     *     @OA\Parameter(
     *         name="deedeeId",
     *         in="path",
     *         description="if of deedee",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             maximum=10,
     *             minimum=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DeeDee"),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(ref="#/components/schemas/DeeDee")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed"
     *     )
     * )
     */
    public function show(Request $request, DeeDee $deedee)
    {
        return response()->json($deedee);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeeDeeRequest  $request
     * @param  \App\Models\DeeDee  $deeDee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeeDeeRequest $request, DeeDee $deedee)
    {
        $deedee->update($request->safe()->all());
       
        return response()->json($deedee->refresh());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeeDee  $deeDee
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeeDee $deedee)
    {
        return tap($deedee->delete(), fn() => response()->json([], 201));
    }
}
