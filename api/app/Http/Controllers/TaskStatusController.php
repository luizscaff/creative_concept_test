<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
  //----------------------------------------------------------------------------------

  public function All()
  {
    try
    {
      $list = TaskStatus::all();

      return response()->json($list);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------
}
