<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultInput extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jsonData = '
        {
            "classes": [
                {"class": "Class 1", "subjects": ["Bangla", "Math", "English"]},
                {"class": "Class 2", "subjects": ["Science", "History", "English"]},
                {"class": "Class 3", "subjects": ["Math", "Geography", "English"]},
                {"class": "Class 4", "subjects": ["Bangla", "Physics", "Chemistry"]},
                {"class": "Class 5", "subjects": ["Economics", "Math", "English"]}
            ]
        }';

        $data = json_decode($jsonData, true);
        return view('inputResult', ['classes' => $data['classes']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
