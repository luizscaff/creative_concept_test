<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Mail\UserStoredMail;
use App\Mail\UserUpdatedMail;
use App\Mail\UserDeletedMail;

use Auth;
use DB;
use Hash;

class UserController extends Controller
{
  //----------------------------------------------------------------------------------

  public function All()
  {
    try
    {
      $list = User::all();

      return response()->json($list);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Get($id)
  {
    try
    {
      $user = User::findOrFail($id);

      return response()->json($user);
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Store(UserRequest $request)
  {
    try
    {
      return DB::transaction(function() use($request)
      {
        $name     = $request["name"];
        $email    = $request["email"];
        $password = Hash::make($request["password"]);
  
        $user = $this->Save($name, $email, $password);
  
        Mail::to($email)->send(new UserStoredMail($user));
  
        return response()->json("Registro criado com sucesso", 200);
      });
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  public function Update(UserRequest $request, $id)
  {
    try
    {
      return DB::transaction(function() use($request, $id)
      {
        $name     = $request["name"];
        $email    = $request["email"];

        if(isset($request["password"]))
          $password = Hash::make($request["password"]);

        $user = $this->Save($name, $email, $password, $id);

        Mail::to($email)->send(new UserUpdatedMail($user));

        return response()->json("Registro atualizado com sucesso", 200);
      });
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------

  private function Save($name, $email, $password = null, $idUser = null)
  {
    if($idUser)
      $user = User::findOrFail($idUser);
    else
      $user = new User();

    $user->name     = $name;
    $user->email    = $email;

    if($password)
      $user->password = $password;

    $user->save();

    return $user;
  }

  //----------------------------------------------------------------------------------

  public function Delete($id)
  {
    try
    {
      return DB::transaction(function() use($id)
      {
        if(Auth::user()->id == $id)
          return response()->json("Você não pode excluir a si mesmo", 401);

        $user = User::findOrFail($id);

        Mail::to($user->email)->send(new UserDeletedMail($user));

        $user->delete();

        return response()->json("Registro excluído com sucesso", 200);
      });
    }
    catch(\Exception $e)
    {
      \Log::error($e);
    }
  }

  //----------------------------------------------------------------------------------
}
