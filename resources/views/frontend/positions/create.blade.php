@extends('frontend.layouts.app')

@section('content')
    <h1>Создание должности</h1>
    <hr>

    {!! Form::open(['route' => 'frontend.user.position.store', 'class' => 'form-horizontal well']) !!}
        <div class="form-group">
            {{ Form::label('Название должности', null, ['class' => 'col-sm-2 control-label', 'for' => 'title']) }}
            <div class="col-sm-10">
                {{ Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Название должности']) }}
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::button("Создать", ["class" => "btn btn-primary", "type" => "submit", 'id' => 'save']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection