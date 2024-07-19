<?php

namespace App\Enums;

enum BloodTypeEnum : string
{
  case Ap = 'A+';
  case An = 'A-';
  case Bp = 'B+';
  case Bn = 'B-';
  case ABp = 'AB+';
  case ABn = 'AB-';
  case Op = 'O+';
  case On = 'O-';
}