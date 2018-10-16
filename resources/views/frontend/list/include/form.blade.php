
    <div class="image-preview-block form-group well">
        {{ Form::label('Фото', null, ['class' => 'col-sm-2 control-label', 'for' => 'image']) }}
        <div class="col-sm-10">
            <div class="image-preview-image">
                <?php $img = $workers['image'] ? 'images/uploads/tasks/w200/'.$workers['image'] : 'img/default.png'; ?>
                <img src="{{ asset($img) }}" class="img-rounded img-thumbnail" style="width: 200px">
            </div>
            <div class="wrapper-delete">
                @if($workers['image'])
                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" data-id="{{ $workers['id'] }}" id="delete-{{ $workers['id'] }}" style="margin-bottom: 10px">
                        <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить"></i>
                        Удалить фото
                    </a>
                @endif
            </div>
            {!! Form::file('image', ['class' => 'image-preview-input form-control', 'id' => 'image']) !!}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Фамилия', null, ['class' => 'col-sm-2 control-label', 'for' => 'last_name']) }}
        <div class="col-sm-10">
            {{ Form::text('last_name', $workers['last_name'], ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Фамилия']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Имя', null, ['class' => 'col-sm-2 control-label', 'for' => 'first_name']) }}
        <div class="col-sm-10">
            {{ Form::text('first_name', $workers['first_name'], ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Имя']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Отчество', null, ['class' => 'col-sm-2 control-label', 'for' => 'patronymic_name']) }}
        <div class="col-sm-10">
            {{ Form::text('patronymic_name', $workers['patronymic_name'], ['class' => 'form-control', 'id' => 'patronymic_name', 'placeholder' => 'Отчество']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Должность', null, ['class' => 'col-sm-2 control-label', 'for' => 'position_id']) }}
        <div class="col-sm-10">
            {{ Form::select('position_id', $positions, $workers['position_id'], ['class' => 'form-control', 'id' => 'position_id', 'placeholder' => 'Должность']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Дата приёма', null, ['class' => 'col-sm-2 control-label', 'for' => 'date_work']) }}
        <div class="col-sm-10">
            {{ Form::date('date_work', \Carbon\Carbon::parse($workers['date_work']), ['class' => 'form-control', 'id' => 'date_work', 'placeholder' => 'Дата приёма']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Размер ЗП', null, ['class' => 'col-sm-2 control-label', 'for' => 'salary']) }}
        <div class="col-sm-10">
            {{ Form::number('salary', $workers['salary'], ['class' => 'form-control', 'id' => 'salary', 'placeholder' => 'Размер ЗП']) }}
        </div>
    </div>


    <div class="form-group well">
        {{ Form::label('Начальник', null, ['class' => 'col-sm-2 control-label', 'for' => 'parent_id']) }}
        <div class="col-sm-10">
            <i>Поиск: Введите часть фамилии или имени или отчества</i><br>
            <input type="text" class="form-control" id="parents-search">
            <div class="wrapper-parent-up">
                <i>Найдено всего:</i><br>
                <i>Показано в списке:</i><br>
            </div>
                @if ($isUpdate)
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
                @endif
                <br>
                <a href="javascript:void(0);" class="btn btn-xs" id="remove-parent" style="margin-bottom: 10px">
                    <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Убрать начальника"></i>
                    Убрать начальника
                </a>
            <div class="wrapper-parent-down">
                {{ Form::select('parent_id', $parents, $workers['parent_id'], ['class' => 'form-control', 'id' => 'parent_id']) }}
            </div>
        </div>
    </div>