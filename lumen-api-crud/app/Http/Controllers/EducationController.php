<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Education;
use Illuminate\Support\Facades\DB;

class EducationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $getAll = Education::select(DB::raw('id,educationGrade'))
            ->orderBy('id')
            ->get();

        return response()->json([$getAll], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'educationGrade' => 'required',
        ]);

        $doInsert = Education::create([
            'educationGrade' => $request->input('educationGrade')
        ]);

        return response()->json(['message' => 'Data added successfully'], 201);
    }
}
