<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\FormTestCreateRequest;
use App\Http\Requests\Test\FormTestUpdateRequest;
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
        $tests = Test::where('is_active', 0)
            ->orderByDesc('id')
            ->paginate(16);

        return view('test.index', compact('tests'));
    }

    public function showTest(Test $test)
    {
        return view('test.show', compact('test'));
    }

    public function createTestForm()
    {
        $categories = Category::limit(100)->get();
        return view('test.create', compact('categories'));
    }

    public function constructTestForm(Test $test)
    {
        return view('test.construct', compact('test'));
    }

    public function constructTestingForm(Test $test)
    {
        $questions = $test->questions()->get();

        return view('test.testing', compact('test', 'questions'));
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
//        dd($request);
        $questions = $request->input('question');
        $answers = $request->input('answer');
        $rightAnswers =  $request->input('correct_answer');
//        dd($questions, $answers, $rightAnswers);

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
        if($test->cover !== "covers/default.png")
        {
            Storage::delete($test->cover);
        }

        $test->delete();

        return redirect()->route('test.index')->with('success', __('test.delete.success.success'));
    }
}
