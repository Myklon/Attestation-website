<div class="col">
    <div class="card shadow-sm">
        <img src="{{ asset("storage/$test->cover") }}" alt="" width="100%"
             style="max-height: 250px; object-fit: contain;">
        <div class="card-body">
            <h3 class="card-title"><a href="{{route('test.show', $test->id)}}">{{$test->title}}</a></h3>
            <p class="card-text"><a
                    href="{{route('category.show', $test->category->id)}}">{{$test->category->title}}</a></p>
            <p class="card-text">{{$test->short_description}}</p>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text">Прохождений теста: {{$test->results->count() ?? 0}}</h5>
                <p class="card-text"><a
                        href="{{route('profile.show', $test->user->id)}}">{{$test->user->login}}</a></p>
            </div>
        </div>
    </div>
</div>

