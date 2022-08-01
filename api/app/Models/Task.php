<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  //----------------------------------------------------------------------------

  protected $table = "Task";
  protected $primaryKey = 'id_task';

  //----------------------------------------------------------------------------

  public function TaskStatus()
  {
    return $this->belongsTo(TaskStatus::Class, 'id_task_status');
  }

  //----------------------------------------------------------------------------

  public function Responsible()
  {
    return $this->belongsTo(User::Class, 'id_user', 'id');
  }

  //----------------------------------------------------------------------------
}
