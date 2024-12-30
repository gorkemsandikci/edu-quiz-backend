<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Tüm soruları getiriyoruz
        $questions = Question::all();
        return response()->json($questions);
    }

    /**
     * Store a newly created question in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|string',
            'question_text' => 'required|string',
            'points' => 'required|integer',
            'question_type' => 'required|string',
            'time_limit' => 'required|integer',
            'order_number' => 'required|integer',
        ]);

        $question = Question::create($validated);

        return response()->json($question, 201);
    }

    /**
     * Display the specified question.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('id', $id)->first();

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        return response()->json($question);
    }
}
