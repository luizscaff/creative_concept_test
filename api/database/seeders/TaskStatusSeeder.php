<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class TaskStatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('TaskStatus')->insert([
      'name' => "Criada"
    ]);
    DB::table('TaskStatus')->insert([
      'name' => "Atrasada"
    ]);
    DB::table('TaskStatus')->insert([
      'name' => "Concluída"
    ]);
    DB::table('TaskStatus')->insert([
      'name' => "Cancelada"
    ]);
  }
}
