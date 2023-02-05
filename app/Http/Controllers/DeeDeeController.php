<?php

namespace App\Http\Controllers;

use App\Models\DeeDee;
use App\Http\Requests\StoreDeeDeeRequest;
use App\Http\Requests\UpdateDeeDeeRequest;
use Illuminate\Http\Request;


class DeeDeeController extends Controller
{

    public function index()
    {
        return response()->json(DeeDee::paginate(15));
    }

    public function store(StoreDeeDeeRequest $request)
    {
        $deedee = DeeDee::create($request->safe()->all());
        return response()->json($deedee); 
    }

    public function show(Request $request, DeeDee $deedee)
    {
        return response()->json($deedee);
    }

    public function update(UpdateDeeDeeRequest $request, DeeDee $deedee)
    {
        $deedee->update($request->safe()->all());
        return response()->json($deedee->refresh());
    }

    public function destroy(DeeDee $deedee)
    {
        return tap($deedee->delete(), fn() => response()->json([], 201));
    }
}
