<?php

namespace App\Http\Controllers;

use App\Models\DeeDee;
use App\Http\Requests\StoreDeeDeeRequest;
use App\Http\Requests\UpdateDeeDeeRequest;

class DeeDeeController extends Controller
{

    public function index()
    {
        return response()->json(DeeDee::paginate(15));
    }

    public function store(StoreDeeDeeRequest $request)
    {
        return tap(DeeDee::create($request->safe()->all()), fn($deedee) => response()->json($deedee));
    }

    public function show(DeeDee $deedee)
    {
        return response()->json($deedee);
    }

    public function update(UpdateDeeDeeRequest $request, DeeDee $deedee)
    {
        return tap($request->safe()->all(), fn($valid) => $deedee->update($valid) && response()->json($deedee->refresh()));
    }

    public function destroy(DeeDee $deedee)
    {
        return tap($deedee->delete(), fn() => response()->json([], 201));
    }
}
