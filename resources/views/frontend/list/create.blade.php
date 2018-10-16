@extends('frontend.layouts.app')

@section('content')
    <h1>Добавление работника</h1>
    <hr>

    <div class="wrapper-massage"></div>

    {!! Form::open(['route' => 'frontend.user.list.store', 'class' => 'form-horizontal well', 'files' => true]) !!}

        <?php
            $parents = [];
            $isUpdate = false;
        ?>
        @include('frontend.list.include.form')

        {{ Form::hidden('id', $workers['id']) }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::button("Сохранить", ["class" => "btn btn-primary", "type" => "submit", 'id' => 'save']) }}
            </div>
        </div>
    {!! Form::close() !!}

    @include('frontend.list.script')


@endsection