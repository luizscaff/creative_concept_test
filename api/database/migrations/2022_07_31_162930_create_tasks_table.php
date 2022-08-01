<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('Task', function (Blueprint $table) {
      $table->bigIncrements('id_task');
      $table->bigInteger('id_task_status')->unsigned();
      $table->string('name');
      $table->bigInteger('id_user')->unsigned()->nullable(); 
      $table->dateTime('due_date');
      $table->bigInteger('created_by')->unsigned();
      $table->timestamps();

      $table->foreign('id_user')->references('id')->on('users');
      $table->foreign('created_by')->references('id')->on('users');
      $table->foreign('id_task_status')->references('id_task_status')->on('TaskStatus');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('Task');
  }
}
