@extends('frontend.layouts.app')

@section('content')
    <h1>Список работников</h1>
    <hr>

    <div class="wrapper-massage">
        @if($massege)
            @if($result)
                <p class="alert alert-success">{{ $massege }}</p>
            @else
                <p class="alert alert-danger">{{ $massege }}</p>
            @endif
        @endif
    </div>

    <a href="{{ route('frontend.user.list.create') }}" class="btn btn-success" style="margin-bottom: 10px">
        Добавить работника
    </a>

    <button class="btn btn-primary glyphicon glyphicon-chevron-down" type="button" data-toggle="collapse" data-target="#search-panel" aria-expanded="false" aria-controls="search-panel" style="margin-bottom: 10px">
        Сортировка и поиск
    </button>

    <div class="collapse" id="search-panel">
        <div class="well">

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Фамилия', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'last_name', true) }}
                        </span>
                        {{ Form::select('last_name', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_last_name']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::text('last_name', null, ['class' => 'form-control', 'id' => 'search_last_name', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Имя', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'first_name', false) }}
                        </span>
                        {{ Form::select('first_name', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_first_name']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'id' => 'search_first_name', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Отчество', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'patronymic_name', false) }}
                        </span>
                        {{ Form::select('patronymic_name', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_patronymic_name']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::text('patronymic_name', null, ['class' => 'form-control', 'id' => 'search_patronymic_name', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Должность', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'position', false) }}
                        </span>
                        {{ Form::select('position', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_position']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::text('position', null, ['class' => 'form-control', 'id' => 'search_position', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Дата приёма', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'date_work', false) }}
                        </span>
                        {{ Form::select('date_work', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_date_work']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::date('date_work', null, ['class' => 'form-control', 'id' => 'search_date_work', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Размер ЗП', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'salary', false) }}
                        </span>
                        {{ Form::select('salary', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_salary']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::number('salary', null, ['class' => 'form-control', 'id' => 'search_salary', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-2">
                    {{ Form::label('Начальник', null, ['class' => 'col-sm-2 control-label']) }}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ Form::radio('sort', 'parent', false) }}
                        </span>
                        {{ Form::select('parent', ['По возрвстанию', 'По убыванию'], 0, ['class' => 'form-control', 'id' => 'sort_parent']) }}
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ Form::text('parent', null, ['class' => 'form-control', 'id' => 'search_parent', 'placeholder' => 'Поиск']) }}
                </div>
            </div>

            <br>

            <div class="row">
                <center class="alert alert-success col-sm-offset-1 col-sm-3" style="padding: 7px">Найдено строк - <b id="count-search"></b></center>
                <button type="button" class="btn btn-primary col-sm-offset-2 col-sm-5" id="search-button">
                    <i class="glyphicon glyphicon-search" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить"></i>
                    Искать (Enter)
                </button>
            </div>

        </div>

    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Должность</th>
                <th>Дата приёма</th>
                <th>Размер ЗП</th>
                <th>Начальник</th>
                <th>Редактировать</th>
            </tr>
        </thead>
        <tbody rows="0">
            {{--AJAX--}}
        </tbody>
    </table>

    <script>
        $(document).ready(function() {

            var loadRowsFunc,        // Загрузка данных
                controlFunc,         // При необходимости догружаем данные
                deleteButtonsFunc,   // Установка событий для кнопок удаления
                optionsCompleteFunc, // Заполнение объекта options
                eventInputsFunc,     // Установка событий для сортировки и поиска
                getSortNameFunc,     // Получить имя сортируемого поля

                isLoading = false,      // Данные загружаются
                addRowsCountStart = 20, // Количество подгружаемых строк при первой загрузке страницы
                addRowsCount = 15;      // Количество подгружаемых строк

            deleteButtonsFunc = function(){
                var buttonsDelete = $('a[id^="delete-"]');
                for(var i = 0; i < buttonsDelete.length; i++) {
                    buttonsDelete[i].addEventListener('click', function(event){
                        var id;
                        if (event.target.tagName != 'A') {
                            id = event.target.closest('A').getAttribute('data-id');
                        } else {
                            id = event.target.getAttribute('data-id');
                        }

                        if (confirm("Вы уверены что хотите удалить работника?")) {
                            startPreloader();
                            $.post(
                                '{{ route('frontend.user.list.destroy') }}',
                                {
                                    id: id,
                                    '_token': '{{ csrf_token() }}'
                                },
                                function(data) {
                                    var massage = $('.wrapper-massage');

                                    massage.empty();
                                    massage.append(data);

                                    if (data.indexOf('success') >= 0) {
                                        event.target.closest('tr').innerHTML = "";
                                    }
                                    stopPreloader();
                                }
                            );
                        }
                        event.preventDefault();
                    });
                };
            };


            loadRowsFunc = function(){
                var options = optionsCompleteFunc(),
                    rows = document.querySelector('tbody').getAttribute('rows'),
                    nRows = Number(rows),
                    countAddRows = Number(rows) > 0 ? addRowsCount : addRowsCountStart;

                if (rows == '-1') return;

                isLoading = true;
                startPreloader();

                $.post(
                    '{{ route('frontend.user.list') }}',
                    {
                        rows: rows,
                        countAddRows: countAddRows,
                        options: JSON.stringify(options),
                        '_token': '{{ csrf_token() }}'
                    },
                    function(data) {
                        var tbody = document.querySelector('tbody'),
                            dataObj = JSON.parse(data),
                            countRows = dataObj.countRows,
                            htmlResult = dataObj.htmlResult;

                        document.querySelector('#count-search').innerHTML = countRows;

                        if (Number(countRows) <= nRows + countAddRows) {
                            // Все данные закачаны
                            tbody.setAttribute('rows', '-1');
                        } else {
                            tbody.setAttribute('rows', nRows + countAddRows);
                        }

                        tbody.innerHTML = nRows > 0 ? tbody.innerHTML + htmlResult : htmlResult;
                        deleteButtonsFunc();

                        isLoading = false;
                        controlFunc();
                        stopPreloader();
                    }
                );
            };


            controlFunc = function() {
                if (isLoading) return;

                var scrollTop,   // Высота прокрученной области
                    windHeight,  // Высота окна браузера
                    pageHeight;  // Высота всей страницы

                windHeight = document.documentElement.clientHeight;
                pageHeight = Math.max(
                    document.body.scrollHeight, document.documentElement.scrollHeight,
                    document.body.offsetHeight, document.documentElement.offsetHeight,
                    document.body.clientHeight, document.documentElement.clientHeight
                );
                scrollTop = window.pageYOffset;

                if ((pageHeight - scrollTop) >= windHeight * 1.8) return;

                loadRowsFunc();
            }


            getSortNameFunc = function(){
                var name,
                    radio = document.getElementsByName('sort');

                for(var i = 0; i < radio.length; i++){
                    if (radio[i].checked) {
                        name = radio[i].value;
                        break;
                    }
                }
                return name;
            }


            optionsCompleteFunc = function(){
                var options = {},
                    names = [
                        'last_name',
                        'first_name',
                        'patronymic_name',
                        'position',
                        'date_work',
                        'salary',
                        'parent',
                        ],
                    sortNameChecked = getSortNameFunc();

                for (var i = 0; i < names.length; i++){
                    var searchName = 'search_' + names[i],
                        sortName = 'sort_' + names[i];

                    options[sortName] = sortNameChecked === names[i] ? document.querySelector('#' + sortName).value : null;
                    options[searchName] = document.querySelector('#' + searchName).value;
                }

                return options;
            };


            eventInputsFunc = function(){
                var inputs = document.querySelectorAll('#search-panel input, #search-panel select'),
                    type,
                    eventFunc;

                eventFunc = function(){
                    var tbody = document.querySelector('tbody');
                    tbody.setAttribute('rows', '0');
                    loadRowsFunc();
                };


                for(var i = 0; i < inputs.length; i++){
                    type = inputs[i].type;

                    // =================
                    // Сортировка
                    // =================
                    if (type == 'select-one') {
                        inputs[i].addEventListener('change', function(e){
                            if (e.target.name == getSortNameFunc()) {
                                eventFunc();
                            };
                        });
                    } else if(type == 'radio') {
                        inputs[i].addEventListener('change', function () {
                            eventFunc();
                        });


                    // =================
                    // Поиск
                    // Будет осуществляться по кнопке и по Enter
                    // =================
                    } else if (type == 'text' || type == 'date') {

                        inputs[i].addEventListener('keydown', function(e){
                            if (e.keyCode === 13) {
                                eventFunc();
                            }
                        });

                    } else if (type == 'number') {

                        inputs[i].addEventListener('keydown', function(e){
                            var elem = e.target,
                                div = elem.closest('div'),
                                num = Number(elem.value);

                            if (num > 0 && Number.isInteger(num) || elem.value == '') {
                                if (elem.value == '') elem.value = '';
                                // eventFunc();
                                div.classList.remove('has-error');
                            } else {
                                div.classList.add('has-error');
                            }

                            if (e.keyCode === 13) {
                                eventFunc();
                            }
                        });
                    };

                }; // for

                // Кнопка
                var buttonSearch = document.querySelector('#search-button');

                buttonSearch.addEventListener('click', function(){
                    eventFunc();
                });
            };


            window.onscroll = function() {
                controlFunc();
            }

            eventInputsFunc();

            loadRowsFunc();

        });
    </script>

@endsection