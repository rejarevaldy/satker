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
            $asf = User::where('role', 'Satker')->get();
            $asd = OneInput::whereYear('created_at', '=', session('year'))->get();

            $arrayforRP = [];
            $arrayforOutput = [];
            $arrayforTarget = [];
            $arrayforUserId = [];
            $sum = 0;
            $sumOutput = 0;
            $sumTarget = 0;
            $total = 0;

            foreach($asf as $user) {
                  foreach ($asd as $one) {
                        if ($one->user_id == $user->id) {
                              $sumOutput += $one->volume_jumlah;
                              $sumTarget += $one->volume_target;
                              $total = $one->user_id;
                              $sum += $one->rp;
                        }
                  }
                  if($sum && $total) {
                        array_push($arrayforUserId, $total);
                        array_push($arrayforRP, $sum);
                        array_push($arrayforOutput, $sumOutput);
                        array_push($arrayforTarget, $sumTarget);
                  }
                  $sumOutput = 0;
                  $sumTarget = 0;
                  $sum = 0;
                  $total = 0;
            }

            $output = [];
            for($i = 0; $i < sizeof($arrayforOutput); $i++) {
                  $www = round(($arrayforOutput[$i] / $arrayforTarget[$i]) * 100, 1);
                  array_push($output, $www);
            }

            $combinedArrayOutput = collect(array_combine($arrayforUserId, $output));
            $combinedArrayMaxOutput = $combinedArrayOutput->sortDesc()->take(5);
            $combinedArrayMaxKeyOutput = $combinedArrayMaxOutput->keys();
            
            $combinedArrayMinOutput = $combinedArrayOutput->sort()->take(5);
            $combinedArrayMinKeyOutput = $combinedArrayMinOutput->keys();

            $combinedArray = collect(array_combine($arrayforUserId, $arrayforRP));
            $combinedArrayMax = $combinedArray->sortDesc()->take(5);
            $combinedArrayMaxKey = $combinedArrayMax->keys();
            
            $combinedArrayMin = $combinedArray->sort()->take(5);
            $combinedArrayMinKey = $combinedArrayMin->keys();
            
            $totalTopMax = [];
            $totalTopMaxKey = [];
            foreach($combinedArrayMax as $value) {
                  array_push($totalTopMax, $value);
            }
            foreach($combinedArrayMaxKey as $value) {
                  array_push($totalTopMaxKey, $value);
            }
            
            $totalTopMin = [];
            $totalTopMinKey = [];
            foreach($combinedArrayMin as $value) {
                  array_push($totalTopMin, $value);
            }
            foreach($combinedArrayMinKey as $value) {
                  array_push($totalTopMinKey, $value);
            }

            $topMaxOutput = [];
            $topMaxOutputKey = [];
            foreach($combinedArrayMaxOutput as $value) {
                  array_push($topMaxOutput, $value);
            }
            foreach($combinedArrayMaxKeyOutput as $value) {
                  array_push($topMaxOutputKey, $value);
            }

            $topMinOutput = [];
            $topMinOutputKey = [];
            foreach($combinedArrayMinOutput as $value) {
                  array_push($topMinOutput, $value);
            }
            foreach($combinedArrayMinKeyOutput as $value) {
                  array_push($topMinOutputKey, $value);
            }

            $totalMax = array_sum($totalTopMax);
            $totalMin = array_sum($totalTopMin);
            $topMax = [];
            $topMin = [];
            if($totalTopMax && $totalTopMin) {
                  for($i = 0; $i < sizeof($totalTopMax); $i++) {
                        $summarymax = round(($totalTopMax[$i] / $totalMax) * 100, 1);
                        $summarymin = round(($totalTopMin[$i] / $totalMin) * 100, 1);
                        array_push($topMax, $summarymax);
                        array_push($topMin, $summarymin);
                  }
            }
            
            if (!isset($topMax[0]) && !isset($topMin[0]) && !isset($topMaxOutput[0]) && !isset($topMinOutput[0])) {
                  $topMax[0] = 0;
                  $topMin[0] = 0;
                  $topMaxOutput[0] = 0;
                  $topMinOutput[0] = 0;
            }
            if (!isset($topMax[1]) && !isset($topMin[1]) && !isset($topMaxOutput[1]) && !isset($topMinOutput[1])) {
                  $topMax[1] = 0;
                  $topMin[1] = 0;
                  $topMaxOutput[1] = 0;
                  $topMinOutput[1] = 0;
            }
            if (!isset($topMax[2]) && !isset($topMin[2]) && !isset($topMaxOutput[2]) && !isset($topMinOutput[2])) {
                  $topMax[2] = 0;
                  $topMin[2] = 0;
                  $topMaxOutput[2] = 0;
                  $topMinOutput[2] = 0;
            }
            if (!isset($topMax[3]) && !isset($topMin[3]) && !isset($topMaxOutput[3]) && !isset($topMinOutput[3])) {
                  $topMax[3] = 0;
                  $topMin[3] = 0;
                  $topMaxOutput[3] = 0;
                  $topMinOutput[3] = 0;
            }
            if (!isset($topMax[4]) && !isset($topMin[4]) && !isset($topMaxOutput[4]) && !isset($topMinOutput[4])) {
                  $topMax[4] = 0;
                  $topMin[4] = 0;
                  $topMaxOutput[4] = 0;
                  $topMinOutput[4] = 0;
            }

            // max
            $usermax1 = 'user';
            $usermax2 = 'user';
            $usermax3 = 'user';
            $usermax4 = 'user';
            $usermax5 = 'user';
            
            if (isset($totalTopMaxKey[0])) {
                  $usermax1 = User::where('id', $totalTopMaxKey[0])->first()->nama;
            }
            if (isset($totalTopMaxKey[1])) {
                  $usermax2 = User::where('id', $totalTopMaxKey[1])->first()->nama;
            }
            if (isset($totalTopMaxKey[2])) {
                  $usermax3 = User::where('id', $totalTopMaxKey[2])->first()->nama;
            }
            if (isset($totalTopMaxKey[3])) {
                  $usermax4 = User::where('id', $totalTopMaxKey[3])->first()->nama;
            }
            if (isset($totalTopMaxKey[4])) {
                  $usermax5 = User::where('id', $totalTopMaxKey[4])->first()->nama;
            }

            // min
            $usermin1 = 'user';
            $usermin2 = 'user';
            $usermin3 = 'user';
            $usermin4 = 'user';
            $usermin5 = 'user';

            if (isset($totalTopMinKey[0])) {
                  $usermin1 = User::where('id', $totalTopMinKey[0])->first()->nama;
            }
            if (isset($totalTopMinKey[1])) {
                  $usermin2 = User::where('id', $totalTopMinKey[1])->first()->nama;
            }
            if (isset($totalTopMinKey[2])) {
                  $usermin3 = User::where('id', $totalTopMinKey[2])->first()->nama;
            }
            if (isset($totalTopMinKey[3])) {
                  $usermin4 = User::where('id', $totalTopMinKey[3])->first()->nama;
            }
            if (isset($totalTopMinKey[4])) {
                  $usermin5 = User::where('id', $totalTopMinKey[4])->first()->nama;
            }
            
            // output max
            $usermaxoutput1 = 'user';
            $usermaxoutput2 = 'user';
            $usermaxoutput3 = 'user';
            $usermaxoutput4 = 'user';
            $usermaxoutput5 = 'user';

            if (isset($topMaxOutputKey[0])) {
                  $usermaxoutput1 = User::where('id', $topMaxOutputKey[0])->first()->nama;
            }
            if (isset($topMaxOutputKey[1])) {
                  $usermaxoutput2 = User::where('id', $topMaxOutputKey[1])->first()->nama;
            }
            if (isset($topMaxOutputKey[2])) {
                  $usermaxoutput3 = User::where('id', $topMaxOutputKey[2])->first()->nama;
            }
            if (isset($topMaxOutputKey[3])) {
                  $usermaxoutput4 = User::where('id', $topMaxOutputKey[3])->first()->nama;
            }
            if (isset($topMaxOutputKey[4])) {
                  $usermaxoutput5 = User::where('id', $topMaxOutputKey[4])->first()->nama;
            }
            
            // output min
            $userminoutput1 = 'user';
            $userminoutput2 = 'user';
            $userminoutput3 = 'user';
            $userminoutput4 = 'user';
            $userminoutput5 = 'user';

            if (isset($topMinOutputKey[0])) {
                  $userminoutput1 = User::where('id', $topMinOutputKey[0])->first()->nama;
            }
            if (isset($topMinOutputKey[1])) {
                  $userminoutput2 = User::where('id', $topMinOutputKey[1])->first()->nama;
            }
            if (isset($topMinOutputKey[2])) {
                  $userminoutput3 = User::where('id', $topMinOutputKey[2])->first()->nama;
            }
            if (isset($topMinOutputKey[3])) {
                  $userminoutput4 = User::where('id', $topMinOutputKey[3])->first()->nama;
            }
            if (isset($topMinOutputKey[4])) {
                  $userminoutput5 = User::where('id', $topMinOutputKey[4])->first()->nama;
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
                  'usermax1' => $usermax1,
                  'usermax2' => $usermax2,
                  'usermax3' => $usermax3,
                  'usermax4' => $usermax4,
                  'usermax5' => $usermax5,
                  'topMax' => $topMax,
                  
                  // TOP RP MIN
                  'usermin1' => $usermin1,
                  'usermin2' => $usermin2,
                  'usermin3' => $usermin3,
                  'usermin4' => $usermin4,
                  'usermin5' => $usermin5,
                  'topMin' => $topMin,
                  
                  // TOP OUTPUT MAX
                  'usermaxoutput1' => $usermaxoutput1,
                  'usermaxoutput2' => $usermaxoutput2,
                  'usermaxoutput3' => $usermaxoutput3,
                  'usermaxoutput4' => $usermaxoutput4,
                  'usermaxoutput5' => $usermaxoutput5,
                  'topMaxOutput' => $topMaxOutput,
                  
                  // TOP OUTPUT MIN
                  'userminoutput1' => $userminoutput1,
                  'userminoutput2' => $userminoutput2,
                  'userminoutput3' => $userminoutput3,
                  'userminoutput4' => $userminoutput4,
                  'userminoutput5' => $userminoutput5,
                  'topMinOutput' => $topMinOutput,

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
