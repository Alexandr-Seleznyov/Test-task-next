@extends('frontend.layouts.app')

@section('content')
    <h1>Редактирование должности</h1>
    <hr>

    {!! Form::open(['route' => 'frontend.user.position.update', 'class' => 'form-horizontal well']) !!}
        <div class="form-group">
            {{ Form::label('Название должности', null, ['class' => 'col-sm-2 control-label', 'for' => 'title']) }}
            <div class="col-sm-10">
                {{ Form::text('title', $position['title'], ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Название должности']) }}
            </div>
        </div>

        {{ Form::hidden('id', $position['id']) }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::button("Сохранить", ["class" => "btn btn-primary", "type" => "submit", 'id' => 'save']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection