<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstNames = ['Ihor', 'Mykola', 'Taras', 'Bogdan', 'Roman', 'Dmytro'];
        $lastNames = ['Pavlechenko', 'Pavliy', 'Tesla', 'Rakovets', 'Miko'];
        $descriptions = ['Good worker', 'Best worker', 'Guru'];


        for($i = 0; $i < 30; $i++) {
            $firstName = $this->getRandomItem($firstNames);
            $lastName = $this->getRandomItem($lastNames);
            $registeredData = $this->getRegisteredDate();

            DB::table('workers')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $this->getEmail($lastName, $firstName),
                'description' => $this->getRandomItem($descriptions),
                'resume' => 'Resume: '.$this->getRandomItem($descriptions),
                'birthday' => $this->getBirthday(),
                'created_at' => $registeredData,
                'updated_at' => $registeredData
            ]);
        }

    }

    private function getRandomItem($source)
    {
        return $source[rand(0, count($source) - 1)];
    }

    private function getEmail(string $lastName, string $firstName)
    {
        return sprintf('%s_%s@gmail.com', $lastName, $firstName);
    }

    private function getBirthday()
    {
        return Carbon::createFromDate(
            rand(1970, 2000),
            rand(1, 11),
            rand(1, 25),
            'Europe/Kiev'
        )->format('Y-m-d');
    }

    private function getRegisteredDate()
    {
        return Carbon::createFromDate(
            rand(2005, 2017),
            rand(1, 11),
            rand(1, 25),
            'Europe/Kiev'
        )->format('Y-m-d');
    }
}
