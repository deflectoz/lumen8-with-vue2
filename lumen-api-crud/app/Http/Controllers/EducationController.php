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

    public function index(Request $request)
    {

        $checkMethod = $request->input('methodType');

        if ($request->isMethod('post')) {
            switch ($checkMethod) {
                case 'getAll':
                    return $this->getAll();
                case 'store':
                    return $this->store($request);
                case 'getById':
                    return $this->getById($request);
                    break;
            }
        }
    }

    public function getAll()
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

    public function getById(Request $id)
    {
        $doFind =  Education::find($id);

        return response()->json([$doFind], 200);
    }
}
