<?php

namespace App\Http\Controllers;

use App\Models\Urk;
use App\Models\User;
use App\Models\Panduan;
use App\Models\OneInput;
use App\Models\TwoInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OutputController extends Controller
{
      public function __construct()
      {
            $this->middleware('auth');
      }

      public function index()
      {
            $rpmax = OneInput::whereYear('created_at', '=', session('year'))->get()->sortByDesc('rp')->take(5);
            $rpmin = OneInput::whereYear('created_at', '=', session('year'))->get()->sortBy('rp')->take(5);
            $rpmax5 = [];
            $rpmin5 = [];
            
            foreach ($rpmax as $value) {
                  array_push($rpmax5, $value->rp);
            }
            foreach ($rpmin as $value) {
                  array_push($rpmin5, $value->rp);
            }

            // Top 5 User
            $allusermax = [];
            $allusermin = [];
            for($i = 0; $i < 5; $i++) {
                  $RPMax1 = OneInput::where('rp', $rpmax5[$i])->get()[0];
                  array_push($allusermax, User::where('id', $RPMax1->user_id)->get()[0]);
                  $RPMin1 = OneInput::where('rp', $rpmin5[$i])->get()[0];
                  array_push($allusermin, User::where('id', $RPMin1->user_id)->get()[0]);
            }

            $totalrpmax5 = array_sum($rpmax5);
            
            $resultMax5RP = [];
            $resultMin5RP = [];

            // TOP 5 MAX RP
            for($i = 0; $i < 5; $i++) {
                  array_push($resultMax5RP, round(($rpmax5[$i] / $totalrpmax5) * 100, 1));
            }
            
            // TOP 5 MIN RP
            for($i = 0; $i < 5; $i++) {
                  array_push($resultMin5RP, round(($rpmin5[$i] / $totalrpmax5) * 100, 1));
            }
            
            $role = Auth::user()->role;

            if ($role == 'Monitoring') {
                  $oneinputs =  OneInput::whereYear('created_at', '=', session('year'));
            } else {
                  $user_id = Auth::user()->id;
                  $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $user_id);
            }

            ##### UMUM Section
            // GET Bidang
            $datas = $oneinputs->get();

            // Chart Anggaran
            $allPagu = [];
            $allRP = [];

            // Chart Output
            $allTarget = [];
            $allRP2 = [];

            // Loop data and push to an empty array above
            foreach ($datas as $data) {
                  array_push($allPagu, $data['pagu']);
                  array_push($allRP, $data['rp']);
                  array_push($allTarget, $data['volume_target']);
                  array_push($allRP2, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPagu and $allRP) {
                  $resultPagu = array_sum($allPagu);
                  $resultRP = array_sum($allRP);

                  // Result Percentage Pie Chart Anggaran
                  $percentage = ($resultRP / $resultPagu) * 100;
                  $resultPercentage =  number_format(floor($percentage * 100) / 100, 1, '.', '');
            } else {
                  $resultPagu = 0;
                  $resultRP = 0;
                  $resultPercentage = 0;
            }

            // Result Chart Output
            if ($allTarget and $allRP2) {
                  $resultTarget = array_sum($allTarget);
                  $resultRP2 = array_sum($allRP2);

                  // Result Percentage Pie Chart Output
                  $percentage2 = ($resultRP2 / $resultTarget) * 100;
                  $resultPercentage2 =  number_format(floor($percentage2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTarget = 0;
                  $resultRP2 = 0;
                  $resultPercentage2 = 0;
            }

            $sisa = $resultPagu - $resultRP;
            ##### end section

            $urks = Urk::all();
            $panduans = Panduan::all();

            return view('output.index', [
                  'urks' => $urks,
                  'panduans' => $panduans,

                  // TOP RP MAX
                  'allusermax' => $allusermax,
                  'resultMax5RP' => $resultMax5RP,
                  
                  // TOP RP MIN
                  'allusermin' => $allusermin,
                  'resultMin5RP' => $resultMin5RP,

                  // datas
                  'pagu' => $resultPagu,
                  'rp' => $resultRP,
                  'rp2' => $resultRP2,
                  'sisa' => $sisa,
                  'percentage' => $resultPercentage,
                  'percentage2' => $resultPercentage2,
                  'target' => $resultTarget
            ]);
      }

      public function list(User $user)
      {
            if (auth()->user()->role !== 'Monitoring') {
                  abort(403);
            }

            $oneinputs = OneInput::whereYear('created_at', '=', session('year'));

            // Sum Volume capaian
            // $oneinputs = OneInput::whereYear('created_at', session('year'))->get();
            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);
                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            ##### UMUM Section
            // GET Bidang
            $datas = $oneinputs->get();

            // Chart Anggaran
            $allPagu = [];
            $allRP = [];

            // Chart Output
            $allTarget = [];
            $allRP2 = [];

            // Loop data and push to an empty array above
            foreach ($datas as $data) {
                  array_push($allPagu, $data['pagu']);
                  array_push($allRP, $data['rp']);
                  array_push($allTarget, $data['volume_target']);
                  array_push($allRP2, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPagu and $allRP) {
                  $resultPagu = array_sum($allPagu);
                  $resultRP = array_sum($allRP);

                  // Result Percentage Pie Chart Anggaran
                  $percentage = ($resultRP / $resultPagu) * 100;
                  $resultPercentage =  number_format(floor($percentage * 100) / 100, 1, '.', '');
            } else {
                  $resultPagu = 0;
                  $resultRP = 0;
                  $resultPercentage = 0;
            }

            // Result Chart Output
            if ($allTarget and $allRP2) {
                  $resultTarget = array_sum($allTarget);
                  $resultRP2 = array_sum($allRP2);

                  // Result Percentage Pie Chart Output
                  $percentage2 = ($resultRP2 / $resultTarget) * 100;
                  $resultPercentage2 =  number_format(floor($percentage2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTarget = 0;
                  $resultRP2 = 0;
                  $resultPercentage2 = 0;
            }

            $sisa = $resultPagu - $resultRP;
            ##### end section



            return view('output.lists', [
                  'data' => $user->where('role', 'Satker')->get(),

                  // datas
                  'pagu' => $resultPagu,
                  'rp' => $resultRP,
                  'rp2' => $resultRP2,
                  'sisa' => $sisa,
                  'percentage' => $resultPercentage,
                  'percentage2' => $resultPercentage2,
                  'target' => $resultTarget

            ]);
      }

      public function rekap(User $user)
      {
            if (auth()->user()->role !== 'Monitoring') {
                  abort(403);
            }

            $id = $user->id;

            $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $id);

            // Sum Volume capaian
            foreach ($oneinputs as $oneinput) {
                  $id = $oneinput->id;

                  $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
                  $oneinput = OneInput::find($id);
                  $sum = array_sum($input);
                  $oneinput->volume_jumlah = $sum;
                  $oneinput->update();
            }

            ##### UMUM Section
            // GET Bidang
            $datas = $oneinputs->get();

            // Chart Anggaran
            $allPagu = [];
            $allRP = [];

            // Chart Output
            $allTarget = [];
            $allRP2 = [];

            // Loop data and push to an empty array above
            foreach ($datas as $data) {
                  array_push($allPagu, $data['pagu']);
                  array_push($allRP, $data['rp']);
                  array_push($allTarget, $data['volume_target']);
                  array_push($allRP2, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPagu and $allRP) {
                  $resultPagu = array_sum($allPagu);
                  $resultRP = array_sum($allRP);

                  // Result Percentage Pie Chart Anggaran
                  $percentage = ($resultRP / $resultPagu) * 100;
                  $resultPercentage =  number_format(floor($percentage * 100) / 100, 1, '.', '');
            } else {
                  $resultPagu = 0;
                  $resultRP = 0;
                  $resultPercentage = 0;
            }

            // Result Chart Output
            if ($allTarget and $allRP2) {
                  $resultTarget = array_sum($allTarget);
                  $resultRP2 = array_sum($allRP2);

                  // Result Percentage Pie Chart Output
                  $percentage2 = ($resultRP2 / $resultTarget) * 100;
                  $resultPercentage2 =  number_format(floor($percentage2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTarget = 0;
                  $resultRP2 = 0;
                  $resultPercentage2 = 0;
            }

            $sisa = $resultPagu - $resultRP;
            ##### end section

            return view('output.rekap', [
                  'user' => $user,
                  'pagu' => $resultPagu,
                  'rp' => $resultRP,
                  'rp2' => $resultRP2,
                  'sisa' => $sisa,
                  'percentage' => $resultPercentage,
                  'percentage2' => $resultPercentage2,
                  'target' => $resultTarget

            ]);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
            //
      }

      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
            //
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show($id)
      {
            //
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit($id)
      {
            //
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, $id)
      {
            //
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function destroy($id)
      {
            //
      }
}
