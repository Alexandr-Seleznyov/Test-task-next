<?php

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormValidation
{
    /**
     * @param \App\Http\Controllers\Controller $controller
     * @param \Illuminate\Http\Request $request
     */
    public static function position(Controller $controller, Request $request)
    {
        $controller->validate(
            $request,
            [
                'title' => [
                    'required',
                    'min:3',
                    'max:255',
                ],
            ],
            [
                'required' => 'Заполните поле <b>":attribute"</b> пожалуйста',
                'min' => 'Поле <b>":attribute"</b> имеет меньше 3-х символов.',
                'max' => 'Поле <b>":attribute"</b> имеет более 255 символов.',
            ],
            [
                'title' => 'Название должности',
            ]
        );
    }

    /**
     * @param \App\Http\Controllers\Controller $controller
     * @param \Illuminate\Http\Request $request
     */
    public static function workers(Controller $controller, Request $request)
    {
        $fio = [
            'required',
            'min:2',
            'max:50',
        ];

        $controller->validate(
            $request,
            [
                'image' => 'image',
                'last_name' => $fio,
                'first_name' => $fio,
                'patronymic_name' => $fio,
                'position_id' => [
                    'required',
                    'integer',
                    'min:1',
                ],
                'date_work' => 'date',
                'salary' => [
                    'integer',
                    'min:0',
                ],
                'parent_id' => [
                    'integer',
                    'min:1',
                ],
            ],
            [
                'image' => 'Загружаемый файл должен быть графическим в поле <b>":attribute"</b>',
                'required' => 'Заполните поле <b>":attribute"</b> пожалуйста',
                'min' => 'Поле <b>":attribute"</b> имеет слишком маленькое значение',
                'max' => 'Поле <b>":attribute"</b> имеет слишком большое значение',
                'integer' => 'Не верное значение у поля <b>":attribute"</b>',
                'date' => 'Не верное значение даты в поле <b>":attribute"</b>',
            ],
            [
                'image' => 'Фото',
                'last_name' => 'Фамилия',
                'first_name' => 'Имя',
                'patronymic_name' => 'Отчество',
                'position_id' => 'Должность',
                'date_work' => 'Дата приёма',
                'salary' => 'Размер ЗП',
                'parent_id' => 'Начальник',
            ]
        );
    }

}