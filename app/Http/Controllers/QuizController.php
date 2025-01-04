<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('userId');

        $quizzes = Quiz::where('creator', $userId)->get()->map(function ($quiz) {
            return [
                'id' => $quiz->id,
                'creator' => $quiz->creator,
                'title' => $quiz->title,
                'duration' => $quiz->duration,
                'liquidity' => $quiz->liquidity,
                'slug' => $quiz->slug,
                'winnerCount' => $quiz->winner_count,
                'description' => $quiz->description,
            ];
        });
        if ($quizzes->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No quizzes found', 'status_code' => 200], 200);
        }

        return response()->json($quizzes);
    }

    public function store(Request $request)
    {
        try {
        $validatedQuiz = $request->validate([
            'userId' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'winnerCount' => 'required|integer',
            'duration' => 'required|integer',
            'liquidity' => 'nullable|integer',
            'questions' => 'required|array',
            'questions.*.markdown' => 'required|string',
            'questions.*.questionType' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.value' => 'required|string',
            'questions.*.answers.*.isCorrect' => 'required|boolean',
        ], [
            'userId.required' => 'User ID is required',
            'title.required' => 'Title is required',
            'winnerCount.required' => 'Winner count is required',
            'duration.required' => 'Duration is required',
            'questions.required' => 'Questions are required',
            'questions.*.markdown.required' => 'Question markdown is required',
            'questions.*.questionType.required' => 'Question type is required',
            'questions.*.answers.required' => 'Answers are required',
            'questions.*.answers.*.value.required' => 'Answer value is required',
            'questions.*.answers.*.isCorrect.required' => 'isCorrect is required',
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        }



        $quiz = Quiz::create([
            'creator' => $validatedQuiz['userId'],
            'title' => $validatedQuiz['title'],
            'description' => $validatedQuiz['description'],
            'winner_count' => $validatedQuiz['winnerCount'],
            'duration' => $validatedQuiz['duration'],
            'liquidity' => $validatedQuiz['liquidity'],
            'slug' => Str::slug($validatedQuiz['title']).'-'.Str::random(4),
        ]);

        foreach ($validatedQuiz['questions'] as $validatedQuestion) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $validatedQuestion['markdown'],
                'question_type' => $validatedQuestion['questionType'],
            ]);

            foreach ($validatedQuestion['answers'] as $validatedAnswer) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $validatedAnswer['value'],
                    'is_correct' => $validatedAnswer['isCorrect']
                ]);
            }
        }
        if ($quiz) {
        return response()->json(['status' => 'success', 'quiz_id' => $quiz->id], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Quiz not created'], 500);
        }
    }

    public function show(Request $request, $id)
    {

        $userId = $request->query('userId');

        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        if ($quiz->creator !== $userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }


        $response = [
            'id' => $quiz->id,
            'title' => $quiz->title,
            'slug' => $quiz->slug,
            'description' => $quiz->description,
            'questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'markdown' => $question->question_text,
                    'questionType' => $question->question_type,
                    'answers' => $question->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'value' => $answer->answer_text,
                            'isCorrect' => $answer->is_correct,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($response);
    }

}
