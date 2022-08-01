<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

use Auth;

class TaskController extends Controller
{ 
  //----------------------------------------------------------------------------------

  public function All()
  {
    try
    {
      $list = Task::with(['TaskStatus', 'Responsible'])
                  ->get();

      return response()->json($list);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Get($idTask)
  {
    try
    {
      $task = Task::with(['TaskStatus', 'Responsible'])
                  ->findOrFail($idTask);

      return response()->json($task);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Store(TaskRequest $request)
  {
    try
    {
      \Log::info(Auth::user()->id);

      $name         = $request["name"];
      $dueDate      = \Carbon\Carbon::parse($request["due_date"]);
      $idTaskStatus = $request["id_task_status"];
      $idUser       = $request["id_user"];
      $idCreator    = Auth::user()->id;

      $this->Save($name, $dueDate, $idTaskStatus, $idUser, $idCreator);

      return response()->json("Registro criado com sucesso", 200);
    }
    catch(\Exception $e)
    {
      \Log::info($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Update(TaskRequest $request, $idTask)
  {
    try
    {
      $name         = $request["name"];
      $dueDate      = \Carbon\Carbon::parse($request["due_date"]);
      $idTaskStatus = $request["id_task_status"];
      $idUser       = $request["id_user"];

      $this->Save($name, $dueDate, $idTaskStatus, $idUser, null, $idTask);

      return response()->json("Registro atualizado com sucesso", 200);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  private function Save($name, $dueDate, $idTaskStatus, $idUser, $idCreator = null, $idTask = null)
  {
    if($idTask)
      $task = Task::findOrFail($idTask);
    else
    {
      $task = new Task();
      $task->created_by = $idCreator;
    }

    $task->name           = $name;
    $task->due_date       = $dueDate;
    $task->id_task_status = $idTaskStatus;
    $task->id_user        = $idUser;

    $task->save();
  }

  //----------------------------------------------------------------------------------

  public function Delete($idTask)
  {
    try
    {
      $task = Task::findOrFail($idTask);
      $task->delete();

      return response()->json("Registro excluído com sucesso", 200);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------
}
