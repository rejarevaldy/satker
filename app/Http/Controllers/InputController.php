<?php

namespace App\Http\Controllers;

use App\Models\OneInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{

      public function __construct()
      {
            $this->middleware('auth');
      }

      public function index()
      {
            $bidang = Auth::user()->bidang;
            $user_id = Auth::user()->id;


            if ($bidang == 'Monitoring') {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->get();
            } else {
                  $datas = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id)->get();
            }

            return view('input.index', [
                  'datas' => $datas
            ]);
      }
}
