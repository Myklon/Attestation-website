<h3 class="mt-4 mb-3">{{$header}}:</h3>

<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3 d-flex align-items-stretch">
    @foreach($tests as $test)
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
    @endforeach
</div>
<div class="mt-3">
    {{ $tests->links() }}
</div>
