<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Phone;

class PhoneController extends Controller
{
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    return response(Phone::create($request->all()), 201);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Phone $phone)
  {
    $phone->delete();

    return Response::HTTP_NO_CONTENT;
  }
}