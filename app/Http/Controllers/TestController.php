<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\FormTestCreateRequest;
use App\Http\Requests\Test\FormTestUpdateRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Result;
use App\Models\RightAnswer;
use App\Models\Test;
use App\Services\TestFileService;
use App\Services\TestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::where('is_active', 1)
            ->orderByDesc('id')
            ->paginate(16);

        return view('test.index', compact('tests'));
    }

    public function showTest(Test $test)
    {
        if($test->is_active == 0) $this->authorize('open', $test);
        return view('test.show', compact('test'));
    }

    public function createTestForm()
    {
        $categories = Category::limit(100)->get();
        return view('test.create', compact('categories'));
    }

    public function constructTestForm(Test $test)
    {
        $questions = $test->questions()->get();
        return view('test.construct', compact('test', 'questions'));
    }

    public function constructEditTestForm(Test $test)
    {
        return view('test.construct', compact('test'));
    }

    public function constructTestingForm(Test $test)
    {
        $this->authorize('open', $test);
        $questions = $test->questions()->get();

        return view('test.testing', compact('test', 'questions'));
    }

    public function showResults(Test $test)
    {
        $this->authorize('seeHistory', $test);
        $results = $test->results()->orderBy('id', 'desc')->get();
        return view('test.results', compact('test', "results"));
    }

    public function calcResults(Request $request, Test $test)
    {
         $answers = $request->input('group');
         $countOfAnswers = count($answers);
         $rightAnswers = 0;
         foreach($answers as $questionId => $answerId)
         {
             $question = Question::where('id', $questionId)->first();
             $rightAnswer = $question->rightAnswers[0]->id;
             if($rightAnswer == $answerId) $rightAnswers++;
         }
        $percentage = ($rightAnswers / $countOfAnswers) * 100;
        $score = round($percentage, 2);

         $result = Result::create([
             'user_id' => Auth::id(),
             'test_id' => $test->id,
             'count_answers' => $countOfAnswers,
             'right_answers' => $rightAnswers,
             'score' => $score
        ]);
//         dd($result);

        return redirect()->route('result.index', $result->id);
    }

    public function construct(Request $request, Test $test)
    {
        $oldQuestions = $request->input('old_question');
        $oldAnswers = $request->input('old_answer');
        $oldRightAnswers =  $request->input('old_correct_answer');

        if(isset($oldQuestions))
        {
            foreach($oldQuestions as $questionId => $questionText)
            {
                $question = Question::findOrFail($questionId);
                if($question->question != $questionText)
                {
                    $question->question = $questionText;
                    $question->save();
                }
                foreach($oldAnswers[$questionId] as $answerId => $answerText)
                {
                    $answer = Answer::findOrFail($answerId);
                    if($answer->answer != $answerText)
                    {
                        $answer->answer = $answerText;
                        $answer->save();
                    }
                }
                $correctAnswer = RightAnswer::where("question_id", $questionId)->get()->first();
                if($oldRightAnswers[$questionId] != $correctAnswer->answer_id)
                {
                    $correctAnswer->answer_id = $oldRightAnswers[$questionId];
                    $correctAnswer->save();
                }
            }
        }

        $questions = $request->input('question');
        $answers = $request->input('answer');
        $rightAnswers =  $request->input('correct_answer');
//        dd($questions, $answers, $rightAnswers);

        if(!isset($questions))
            return redirect()->route('test.show', $test->id)->with('success', __('testing.create.success.success'));


        foreach ($questions as $questionId => $question) {
            $createdQuestion = Question::create([
                'question' => $question,
                'test_id' => $test->id,
            ]);

            foreach ($answers[$questionId + 1] as $answerId => $answer) {
                $createdAnswer = $createdQuestion->answers()->create([
                    'answer' => $answer,
                ]);

                if ($rightAnswers[$questionId + 1] == $answerId) {
                    $createdQuestion->rightAnswers()->attach($createdAnswer);
                }
            }
        }
        if(isset($request->publication)){
            $test->is_active = 1;
        }
        else {
            $test->is_active = 0;
        }
        $test->save();

        return redirect()->route('test.show', $test->id)->with('success', __('testing.create.success.success'));
    }

    public function store(FormTestCreateRequest $request, TestFileService $testFileService)
    {
//        $data = $request->only('title','short_description','description','price','category_id');
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        if($request->file('cover')) $data['cover'] = TestService::handleUploadedCover($request->cover);

        $test = Test::create($data);

//        ProductService::handleUploadedFiles($request->file('files'), $test->id);

        return redirect()->route('test.show', $test->id)->with('success', __('test.create.success.success'));
    }

    public function editTestForm(Test $test)
    {
        $this->authorize('edit', $test);
        $categories = Category::limit(100)->get();
        return view('test.edit', compact('categories', 'test'));
    }

    public function update(FormTestUpdateRequest $request, Test $test)
    {
        $this->authorize('edit', $test);
        $data = $request->validated();

        if($request->hasFile('cover')) {
            if($test->cover === "covers/default.png")
            {
                $cover = $request->cover->store('covers');
                $data['cover'] = $cover;
            }
            else {
                $cover = $request->file('cover')->storeAs('', $test->cover);
            }
        }

        $test->update($data);

        return redirect()->route('test.show', $test->id)->with('success', __('test.edit.success.success'));
    }

    public function removeTest(Test $test)
    {
        $this->authorize('delete', $test);
//        if($test->cover !== "covers/default.png")
//        {
//            Storage::delete($test->cover);
//        }

        $test->is_active = 0;
        $test->save();

        return redirect()->route('test.index')->with('success', __('test.delete.success.success'));
    }
}
