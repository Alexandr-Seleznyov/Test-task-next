<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

/**
 * Class PostsSeeder.
 */
class WorkersSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    private $array = [];
    private $count = 0;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $workers = $this->getArrayData();

//        DB::table('workers')->insert($workers);

        // Для увелечения скорости загрузки, будем загружать данные по частям.
        $counter = 0;
        $part_array = [];
        foreach($workers as $w)
        {
            if ($counter < 1000) {
                $counter++;
                $part_array[$counter] = $w;
            } else {
                DB::table('workers')->insert($part_array);
                $counter = 0;
                unset($part_array);
                $part_array = [];
            }
        }

        if ($counter > 0) {
            DB::table('workers')->insert($part_array);
        }

        $this->enableForeignKeys();
    }

    private function getArrayData()
    {
        $options = [
            [
                'count' => 3,  // Количество начальников 1-го уровня
                'id' => 1,     // Переменная
            ],
            [
                'count' => 5,  // Количество начальников 2-го уровня
                'id' => 1,     // Переменная
            ],
            [
                'count' => 6,  // Количество начальников 3-го уровня
                'id' => 1,     // Переменная
            ],
            [
                'count' => 7,  // Количество начальников 4-го уровня
                'id' => 0,     // Переменная
            ],
            [
                'count' => 8,  // Количество начальников 5-го уровня
                'id' => 0,     // Переменная
            ],
            [
                'count' => 10,  // Количество работников у начальников 5-го уровня
                'id' => 0,      // Переменная
            ],
        ];

        $this->addRowsToArray(0, $options);

//        // -- TEST >>
//
//        $this->array = [
//            [
//                'id' => 1,
//                'parent_id' => null,
//                'position_id' => 1,
//                'last_name' => '1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 2,
//                'parent_id' => 1,
//                'position_id' => 1,
//                'last_name' => '1.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 3,
//                'parent_id' => 1,
//                'position_id' => 1,
//                'last_name' => '1.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 4,
//                'parent_id' => 1,
//                'position_id' => 1,
//                'last_name' => '1.3',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 5,
//                'parent_id' => 2,
//                'position_id' => 1,
//                'last_name' => '1.1.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 6,
//                'parent_id' => 2,
//                'position_id' => 1,
//                'last_name' => '1.1.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 7,
//                'parent_id' => 3,
//                'position_id' => 1,
//                'last_name' => '1.2.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 8,
//                'parent_id' => 3,
//                'position_id' => 1,
//                'last_name' => '1.2.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 9,
//                'parent_id' => 4,
//                'position_id' => 1,
//                'last_name' => '1.3.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 10,
//                'parent_id' => 4,
//                'position_id' => 1,
//                'last_name' => '1.3.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 11,
//                'parent_id' => 7,
//                'position_id' => 1,
//                'last_name' => '1.2.1.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 12,
//                'parent_id' => 7,
//                'position_id' => 1,
//                'last_name' => '1.2.1.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 13,
//                'parent_id' => 11,
//                'position_id' => 1,
//                'last_name' => '1.2.1.1.1',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ],
//            [
//                'id' => 14,
//                'parent_id' => 11,
//                'position_id' => 1,
//                'last_name' => '1.2.1.1.2',
//                'first_name' => 'Фамилия',
//                'patronymic_name' => 'Отчество',
//                'salary' => 123,
//                'date_work' => $this->randomDate(),
//                'created_at' => Carbon::now(),
//                'updated_at' => null,
//            ]
//
//        ];
//
//        // -- TEST <<


        return $this->array;
    }


    private function addRowsToArray($i, $options)
    {
        if ($i >= count($options)) return $options;

        for($j = 0; $j < $options[$i]['count']; $j++) {

            $parent = $i == 0 ? null : $options[$i - 1]['id'];
            $this->count++;
            $options[$i]['id'] = $this->count;

            $position_id = ($i == count($options) - 1) ? $j + 6 : $i + 1;

            $this->array[$options[$i]['id'] - 1] = [
                'id' => $options[$i]['id'],
                'parent_id' => $parent,
                'position_id' => $position_id,
                'first_name' => 'Имя '.($options[$i]['id']),
                'last_name' => 'Фамилия '.($options[$i]['id']),
                'patronymic_name' => 'Отчество '.($options[$i]['id']),
                'salary' => $this->randomSalary(),
                'date_work' => $this->randomDate(),
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ];

            $this->addRowsToArray($i + 1, $options);

        }
    }



    private function randomDate()
    {
        $start_date = '2000-01-01 00:00:00';
        $end_date = '2018-10-08 00:00:00';

        $min = strtotime($start_date);
        $max = strtotime($end_date);

        $val = rand($min, $max);

        return date('Y-m-d', $val);
//        return date('Y-m-d H:i:s', $val); // Бывают ошибки. Переход на летнее время
    }


    private function randomSalary()
    {
        return rand(500, 10000);
    }

}
