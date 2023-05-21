<div id="questions">
</div>

<div id="questions">
    <button type="button" class="btn btn-success mb-3" onclick="addQuestion()">Добавить вопрос</button>
</div>
<div class="form-group form-check mb-3">
    <label class="form-check-label">
        <input class="form-check-input"  name="publication" type="checkbox"> Опубликовать
    </label>
</div>
<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{$button}}</button>
    <p id="count" class="count mt-3"></p>
</div>

<script>
    let questionIndex = 0;
    let current = 0;

    function addQuestion() {
        current++;
        document.getElementById("count").innerHTML = "Всего вопросов: " + current;

        questionIndex++;

        const questionGroup = document.createElement('div');
        questionGroup.classList.add('question-group', 'mb-4');

        const questionLabel = document.createElement('label');
        questionLabel.setAttribute('for', 'question');
        questionLabel.textContent = 'Вопрос №:';

        const questionInput = document.createElement('input');
        questionInput.setAttribute('type', 'text');
        questionInput.classList.add('form-control');
        questionInput.setAttribute('name', 'question[]');
        questionInput.setAttribute('placeholder', 'Введите вопрос');
        questionInput.required = true;
        {{--questionInput.value = "{{ old('question.' + questionIndex) }}";--}}

        const answersLabel = document.createElement('label');
        answersLabel.setAttribute('for', 'answer');
        answersLabel.textContent = 'Ответы:';

        const answerGroup = document.createElement('div');
        answerGroup.classList.add('answer-group');

        for (let i = 0; i < 4; i++) {
            const answerWrapper = document.createElement('div');
            answerWrapper.classList.add('answer-wrapper');

            const answerRadio = document.createElement('input');
            answerRadio.setAttribute('type', 'radio');
            answerRadio.classList.add('mr-2');
            answerRadio.classList.add('form-check-input');
            answerRadio.setAttribute('name', 'correct_answer[' + questionIndex + ']');
            answerRadio.required = true;
            answerRadio.value = i; // Значение радиокнопки - порядковый номер варианта ответа
            if (i === 0) {
                answerRadio.checked = true; // Первый вариант ответа по умолчанию выбран как правильный
            }

            const answerInput = document.createElement('input');
            answerInput.setAttribute('type', 'text');
            answerInput.classList.add('form-control', 'mb-2');
            answerInput.setAttribute('name', 'answer[' + questionIndex + '][]');
            answerInput.setAttribute('placeholder', 'Введите вариант ответа');
            answerInput.required = true;

            answerWrapper.appendChild(answerRadio);
            answerWrapper.appendChild(answerInput);
            answerGroup.appendChild(answerWrapper);
        }

        const deleteButton = document.createElement('button');
        deleteButton.classList.add('btn', 'btn-danger', 'mb-2');
        deleteButton.textContent = 'Удалить вопрос';
        deleteButton.addEventListener('click', function () {
            questionGroup.remove();
            current--;
            document.getElementById("count").innerHTML = "Всего вопросов: " + current;
        });

        questionGroup.appendChild(questionLabel);
        questionGroup.appendChild(questionInput);
        questionGroup.appendChild(answersLabel);
        questionGroup.appendChild(answerGroup);
        questionGroup.appendChild(deleteButton);

        document.getElementById('questions').appendChild(questionGroup);
    }
</script>
<style>
    .answer-wrapper {
        display: flex;
        align-items: center;
    }
    .answer-wrapper input[type="radio"] {
        margin-right: 10px;
    }
</style>
