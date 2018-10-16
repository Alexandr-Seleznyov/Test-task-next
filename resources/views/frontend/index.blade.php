@extends('frontend.layouts.app')

@section('content')

    <h1>Работники компании</h1>
    <h6>При раскрытии списка подчинённых, этот список загружается без перезагрузки страницы.</h6>
    <h6>Изменить начальника сотрудника можно, перетащив его на строку другого начальника</h6>
    <i>После изменения начальника, может произойти перераспределение сотрудников.
        <button type="button" class="btn btn-file" data-toggle="modal" data-target=".modal-image" id="image-parents">Например</button>
    </i>
    <div class="modal fade modal-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <center class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Пример перераспределения</h4>
                </div>
                <img src="{{ asset('img/parents.png') }}" class="img-rounded img-thumbnail">
            </center>
        </div>
    </div>
    <hr>

    @foreach($workers as $value)
        <?php $countChilds = $value->countChilds($value['id']) ?>
        <div class="panel-group" role="tablist">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading_{{ $value['id'] }}">
                    <div class="row">
                        <?php $col = 'col-md-offset-2'; ?>
                        @if($countChilds)
                            <a href="#{{ $value['id'] }}" class="btn btn-default col-md-2" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="{{ $value['id'] }}">
                                <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> Подчинённые <span class="badge">{{ $countChilds }}</span>
                            </a>
                            <?php $col = ''; ?>
                        @endif
                        <ul class="nav nav-pills task col-md-9$col {{ $col }}">
                            <li class="task-fio">{{ $value['last_name'] }}</li>
                            <li class="task-fio">{{ $value['first_name'] }}</li>
                            <li class="task-fio">{{ $value['patronymic_name'] }}</li>
                            <li class="task-position">{{ $value->position['title'] }}</li>
                            <li class="task-date">{{ \Carbon\Carbon::parse($value['date_work'])->format('d-m-Y') }}</li>
                            <li class="task-salary">{{ $value['salary'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="wrapper-childs-{{ $value['id'] }}"></div>
            </div>
        </div>
    @endforeach

    {{ Html::script('js/drag_n_drop.js') }}

    <script>
        var url, token;
        $(document).ready(function() {

            url = '{{ route('frontend.list.editparent') }}';
            token =  '{{ csrf_token() }}';

            var buttons = $('.panel-heading .btn');

            var buttonClick = function(event){

                event.preventDefault();

                var id = event.target.getAttribute('aria-controls'),
                    childs = $('.wrapper-childs-' + id);

                if (!event.target.hasAttribute('clicked')) {
                    event.target.setAttribute('clicked', '');

                    startPreloader();

                    $.post(
                        '{{ route('frontend.childs.get') }}',
                        {
                            id: id,
                            '_token': '{{ csrf_token() }}'
                        },
                        function(data) {
                            childs.empty();
                            childs.append(data);

                            var buttons = $('.panel-heading .btn');
                            for(var i = 0; i < buttons.length; i++) {
                                if (buttons[i].hasAttribute('clicked')) {
                                    continue;
                                }

                                buttons[i].addEventListener('click', function(event){
                                    buttonClick(event);
                                });
                            }
                            stopPreloader();
                        }
                    );
                }
            };


            for(var i = 0; i < buttons.length; i++) {
                buttons[i].addEventListener('click', function(event){
                    buttonClick(event)
                });
            }
        });
    </script>

@endsection