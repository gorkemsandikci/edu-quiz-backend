<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Tüm quiz'leri listele
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }

    // Yeni bir quiz oluştur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create($validated);
        return response()->json($quiz, 201);
    }

    // Belirli bir quiz'i görüntüle
    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return response()->json($quiz);
    }

    // Belirli bir quiz'i güncelle
    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($validated);
        return response()->json($quiz);
    }

    // Belirli bir quiz'i sil
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully']);
    }


    /**
     * Store a newly created question and its answer in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addQuestion(Request $request, string $id)
    {
        $validatedQuestion = $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer',
            'question_type' => 'required|string',
            'time_limit' => 'required|integer',
            'order_number' => 'required|integer',
        ]);

        $validatedAnswers = $request->validate([
            'answers' => 'required|array',
            'answers.*.answer_text' => 'required|string',
            'answers.*.is_correct' => 'required|boolean',
            'answers.*.explanation' => 'nullable|string',
        ]);


        $quiz = Quiz::findOrFail($id);
        $question = new Question($validatedQuestion);
        $quiz->questions()->save($question);

        foreach ($validatedAnswers['answers'] as $validatedAnswer) {
            $validatedAnswer['question_id'] = $question->id;
            $answer = new Answer($validatedAnswer);
            $question->answers()->save($answer);
        }

        return response()->json($question, 201);
    }

}
