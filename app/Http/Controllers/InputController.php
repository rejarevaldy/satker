<?php

namespace App\Http\Controllers;

use App\Models\OneInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{
      public function index()
      {
            $bidang = Auth::user()->bidang;
            $user_id = Auth::user()->id;

            if ($bidang == 'Admin') {
                  $datas = OneInput::whereYear('created_at', session('tahun'))->get();
            } else {
                  $datas = OneInput::where('user_id', $user_id)->whereYear('created_at', session('tahun'))->get();
            }
      }
}
