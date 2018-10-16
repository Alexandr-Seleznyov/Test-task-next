@extends('frontend.layouts.app')

@section('content')
    <h1>Должности работников</h1>
    <hr>

    <div class="wrapper-massage">
        @if($massege)
            @if($result)
                <div class="alert alert-success">{{ $massege }}</div>
            @else
                <div class="alert alert-danger">{{ $massege }}</div>
            @endif
        @endif
    </div>

    <table class="table table-bordered table-striped">
        <th>id</th>
        <th>Наименование должности</th>
        <th>Редактировать</th>
    @foreach($positions as $value)
        <tr>
            <td>{{ $value['id'] }}</td>
            <td>{{ $value['title'] }}</td>
            <td>
                <a href="{{ route('frontend.user.position.edit', array('id' => $value['id'])) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-xs btn-danger" data-id="{{ $value['id'] }}" id="delete-{{ $value['id'] }}">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить"></i>
                </a>

            </td>
        </tr>
    @endforeach

    </table>

    <a href="{{ route('frontend.user.position.create') }}" class="btn btn-success btn-sm">
        Добавить должность
    </a>

    <script>
        $(document).ready(function() {
            var buttonsDelete = $('a[id^="delete-"]');
            for(var i = 0; i < buttonsDelete.length; i++) {
                buttonsDelete[i].addEventListener('click', function(event){
                    var id;
                    if (event.target.tagName != 'A') {
                        id = event.target.closest('A').getAttribute('data-id');
                    } else {
                        id = event.target.getAttribute('data-id');
                    }

                    if (confirm("Вы уверены что хотите удалить должность?")) {
                        $.post(
                            '{{ route('frontend.user.position.destroy') }}',
                            {
                                id: id,
                                '_token': '{{ csrf_token() }}'
                            },
                            function(data) {
                                var massage = $('.wrapper-massage');

                                massage.empty();
                                massage.append(data);

                                if (data.indexOf('success')) {
                                    event.target.closest('tr').innerHTML = "";
                                };
                            }
                        );
                    }
                    event.preventDefault();
                });
            }
        });
    </script>

@endsection