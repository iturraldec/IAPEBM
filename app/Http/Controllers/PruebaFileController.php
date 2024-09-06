<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//
class PruebaFileController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('prueba-file');
  }

  public function store(Request $request)
  {
    if($request->hasFile('prueba')) {
      /* $file = new MyFile;
      $file->setPath('public/employees');
      $fileName = $file->store($request->file('prueba'));
      echo $fileName.'<br>';
      echo 'url: '.asset('images/' . basename($fileName)); */

      /* $path = Storage::putFile('public/employees', new File($request->file('prueba')->getRealPath()));
      echo $path;
      echo '<br>url: '.asset('images/' . basename($path)); */
      $file = $request->prueba->store('public/employees');
      echo "$file<br>";
      echo asset("images/".basename($file));
    }
  }
}