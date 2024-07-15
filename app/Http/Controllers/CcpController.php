<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CcpController extends Controller
{
  //
  public function getCcps()
  {
    $ccps = DB::table('ccps_g')->orderBy('name')->get();

    return response(['ccps' => $ccps], 200);
  }

  //
  public function getCcpsByCcp(int $ccp_id)
  {
    $ccpse = DB::table('ccps_e')->where('ccp_id', $ccp_id)->orderBy('name')->get();

    return response(['ccpse' => $ccpse], 200);
  }
}