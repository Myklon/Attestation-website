@foreach ($questions as $index => $question)
    <div class="card border-info mb-4 ">
        <div class="card-header bg-info text-white">
            <span>Вопрос {{$index + 1}}</span>
        </div>
        <div class="card-body">
            <p>{{$question->question}}</p>
            <fieldset id='group[{{$question->id}}]'>
                @foreach ($question->answers()->get() as $answerIndex => $answer)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="group[{{$question->id}}]"
                        id="a{{$answerIndex +1 }}[{{$question->id}}]"
{{--                        value="a{{$answerIndex +1 }}[{{$question->id}}]"--}}
                        value="{{$answer->id}}"
                        required>
                    <label
                        class="form-check-label"
                        for="a{{$answerIndex + 1 }}[{{$question->id}}]">
                        {{ $answer->answer }}
                    </label>
                </div>
                @endforeach
            </fieldset>
        </div>
    </div>
@endforeach

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{$button}}</button>
</div>

<style>
    .answer-wrapper {
        display: flex;
        align-items: center;
    }
    .answer-wrapper input[type="radio"] {
        margin-right: 10px;
    }
</style>
