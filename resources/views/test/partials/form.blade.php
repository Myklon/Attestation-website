<div class="form-group mb-3">
    <label for="title">Название тестирования:</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Введите название тестирования"
           value="{{ $test->title ?? old('title') }}">
    @error('title')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="category">Выберите категорию:</label>
    <select name="category_id" id="category" class="form-control">
        @foreach($categories as $category)
            <option
                {{ $categoryId = isset($test) ? $test->category_id : old('category_id') }}
                {{ $categoryId == $category->id ? ' selected ' : '' }}
                value="{{$category->id}}">{{$category->title}}</option>
        @endforeach
    </select>
    @error('category_id')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="title">Краткое описание:</label>
    <input type="text" class="form-control" id="short_description" name="short_description"
           placeholder="Введите краткое описание к тестированию"
           value="{{ $test->short_description ?? old('short_description') }}">
    @error('short_description')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="description">Полное описание тестирования:</label>
    <textarea class="form-control" id="description"
              name="description"> {{ $test->description ?? old('description') }} </textarea>
    @error('description')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
<div class="mb-3">
    <label for="formFile" class="form-label">Загрузить обложку</label>
    <input name="cover" class="form-control" type="file" id="formFile">
    @error('cover')
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
<button type="submit" class="btn btn-primary">{{$button}}</button>
