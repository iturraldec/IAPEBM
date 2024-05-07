<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
  //
  public function store(Phone $phone)
  {
    return Phone::created($phone);
  }
}
