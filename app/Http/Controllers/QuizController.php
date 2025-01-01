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

    public function store(Request $request)
    {
        $validatedQuiz = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.points' => 'required|integer',
            'questions.*.question_type' => 'required|string',
            'questions.*.time_limit' => 'required|integer',
            'questions.*.order_number' => 'required|integer',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer_text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
            'questions.*.answers.*.explanation' => 'nullable|string',

        ]);

        $quiz = Quiz::create($validatedQuiz);


        foreach ($validatedQuiz['questions'] as $validatedQuestion) {
            $validatedQuestion['quiz_id'] = $quiz->id;
            $question = Question::create($validatedQuestion);

            foreach ($validatedQuestion['answers'] as $validatedAnswer) {
                $validatedAnswer['question_id'] = $question->id;
                Answer::create($validatedAnswer);
            }
        }

        return response()->json($quiz, 200);
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        $response = [
            'id' => $quiz->id,
            'title' => $quiz->title,
            'description' => $quiz->description,
            'questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'points' => $question->points,
                    'question_type' => $question->question_type,
                    'time_limit' => $question->time_limit,
                    'order_number' => $question->order_number,
                    'answers' => $question->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'answer_text' => $answer->answer_text,
                            'is_correct' => $answer->is_correct,
                            'explanation' => $answer->explanation,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($response);
    }

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
