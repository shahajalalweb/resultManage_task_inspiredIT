<?php

namespace App\Http\Controllers;

use App\Models\Result;

use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class ResultInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::all(); // Fetching all results
        // Define a simple list of classes and subjects.
        $classes = [
            ['class' => 'Class 1', 'subjects' => ['Bangla', 'Math', 'English']],
            ['class' => 'Class 2', 'subjects' => ['Science', 'Math', 'English']],
            // Add more classes and subjects as needed
        ];

        // Pass data to the Blade view
        return view('inputResult', [
            'classes' => $classes,
            'results' => $results // Pass results data to Blade
        ]);
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
        $results = Result::where('examination', $request->examination)->where('roll', $request->roll)->get();

        if (count($results) < 1 ) {

                    // Validate the input data
                    $validatedData = $request->validate([
                        'class' => 'required|string',
                        'examination' => 'required|string',
                        'roll' => 'required|string',  // Validate roll as required
                        'marks' => 'required|array', // An array of subject marks
                        'marks.*' => 'required|integer|min:1|max:100', // Marks for each subject must be between 1 and 100
                    ]);

                    // Save the result data in the database
                    $result = new Result();
                    $result->class = $validatedData['class'];
                    $result->examination = $validatedData['examination'];
                    $result->roll = $validatedData['roll']; // Save the roll number
                    $result->subjects_marks = $validatedData['marks']; // Save marks as JSON
                    $result->save();


                    // Redirect with a success message
                    return redirect()->route('inputResult')->with('success', 'Results saved successfully.');
        }else {
            return redirect()->route('inputResult')->with('error', 'Results Already publis.');
        }
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

    public function destroy($id)
    {
        // Find the result by ID
        $result = Result::findOrFail($id);

        // Delete the result
        $result->delete();

        // Redirect back to the list with a success message
        return redirect()->route('inputResult')->with('delete', 'Result deleted successfully!');
    }
}
