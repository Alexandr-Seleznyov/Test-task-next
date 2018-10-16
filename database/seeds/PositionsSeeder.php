<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

/**
 * Class PostsSeeder.
 */
class PositionsSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    private $positions = [];

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $positions = $this->getArrayData();

        DB::table('positions')->insert($positions);

        $this->enableForeignKeys();
    }

    private function getArrayData()
    {
        for ($i = 0; $i < 5; $i++)
        {
            $this->positions[$i] = [
                'id' => $i + 1,
                'title'       => 'Начальник '.($i + 1).'-го уровня',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ];
        }

        for ($i = 5; $i < 15; $i++)
        {
            $this->positions[$i] = [
                'id' => $i + 1,
                'title'       => 'Должность '.($i - 4),
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ];
        }

        return $this->positions;
    }
}
