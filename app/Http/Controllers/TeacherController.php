<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.index');
    }
    public function allData()
    {
        $allData = Teacher::orderBy('id', 'DESC')->get();
        return response()->json($allData);
       // return view('teacher.index', compact('allData'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);
        $data = Teacher::insert([
            'name' =>$request->name,
            'title' =>$request->title,
            'institute' =>$request->institute,
        ]);
        return response()->json($data);
    }
    public function edit($id){
        $data = Teacher::find($id);
        return response()->json($data);
    }
}
