@extends('frontend.layouts.app')

@section('content')
    <h1>Редактирование работника</h1>
    <hr>

    <div class="wrapper-massage"></div>

    {!! Form::open(['route' => 'frontend.user.list.update', 'class' => 'form-horizontal well', 'files' => true]) !!}

        <?php $isUpdate = true; ?>
        @include('frontend.list.include.form')

        {{ Form::hidden('id', $workers['id']) }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::button("Сохранить", ["class" => "btn btn-primary", "type" => "submit", 'id' => 'save']) }}
            </div>
        </div>
    {!! Form::close() !!}


    @include('frontend.list.script')

    <script>
        $(document).ready(function() {

            // Удаление Фото

            var buttonsDelete = $('a[id^="delete-"]');
            if (buttonsDelete.length > 0) {
                buttonsDelete[0].addEventListener('click', function(event){
                    var id;
                    if (buttonsDelete[0].tagName != 'A') {
                        id = buttonsDelete[0].closest('A').getAttribute('data-id');
                    } else {
                        id = buttonsDelete[0].getAttribute('data-id');
                    }

                    console.log(id);

                    if (confirm("Вы уверены что хотите удалить Фото?")) {
                        $.post(
                            '{{ route('frontend.user.image.delete') }}',
                            {
                                id: id,
                                '_token': '{{ csrf_token() }}'
                            },
                            function(data) {
                                var massage = $('.wrapper-massage');

                                massage.empty();
                                massage.append('<div class="alert alert-success">Фото удалено</div>');

                                $('.wrapper-delete').empty();
                            }
                        );
                    }
                    event.preventDefault();
                });
            }


        });
    </script>


@endsection