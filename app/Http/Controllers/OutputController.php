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
            // $dataUMUM = $oneinputs->filter(function($value) {
            //       return $value['bidang'] == 'Umum';
            // });
            $dataUMUM = $oneinputs->where('bidang', 'Umum')->get();
            // dd($dataUMUM);

            // Chart Anggaran
            $allPaguUmum = [];
            $allRPUmum = [];

            // Chart Output
            $allTargetUmum = [];
            $allRP2Umum = [];

            // Loop data and push to an empty array above
            foreach ($dataUMUM as $data) {
                  array_push($allPaguUmum, $data['pagu']);
                  array_push($allRPUmum, $data['rp']);
                  array_push($allTargetUmum, $data['volume_target']);
                  array_push($allRP2Umum, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPaguUmum and $allRPUmum) {
                  $resultPaguUMUM = array_sum($allPaguUmum);
                  $resultRPUMUM = array_sum($allRPUmum);

                  // Result Percentage Pie Chart Anggaran
                  $percentageUMUM = ($resultRPUMUM / $resultPaguUMUM) * 100;
                  $resultPercentageUMUM =  number_format(floor($percentageUMUM * 100) / 100, 1, '.', '');
            } else {
                  $resultPaguUMUM = 0;
                  $resultRPUMUM = 0;
                  $resultPercentageUMUM = 0;
            }

            // Result Chart Output
            if ($allTargetUmum and $allRP2Umum) {
                  $resultTargetUMUM = array_sum($allTargetUmum);
                  $resultRP2UMUM = array_sum($allRP2Umum);

                  // Result Percentage Pie Chart Output
                  $percentageUMUM2 = ($resultRP2UMUM / $resultTargetUMUM) * 100;
                  $resultPercentageUMUM2 =  number_format(floor($percentageUMUM2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTargetUMUM = 0;
                  $resultRP2UMUM = 0;
                  $resultPercentageUMUM2 = 0;
            }

            $sisaUMUM = $resultPaguUMUM - $resultRPUMUM;
            ##### end section

            ##### PPAI Section
            // GET Bidang
            $dataPPAI = $oneinputs->where('bidang', 'PPA I')->get();

            // Anggaran
            $allPaguPPAI = [];
            $allRPPPAI = [];

            // Output
            $allTargetPPAI = [];
            $allRP2PPAI = [];

            // Loop data and push to an empty array above
            foreach ($dataPPAI as $data) {
                  array_push($allPaguPPAI, $data['pagu']);
                  array_push($allRPPPAI, $data['rp']);
                  array_push($allTargetPPAI, $data['volume_target']);
                  array_push($allRP2PPAI, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPaguPPAI and $allRPPPAI) {
                  $resultPaguPPAI = array_sum($allPaguPPAI);
                  $resultRPPPAI = array_sum($allRPPPAI);

                  // Result Percentage Pie Chart Anggaran
                  $percentagePPAI = ($resultRPPPAI / $resultPaguPPAI) * 100;
                  $resultPercentagePPAI =  number_format(floor($percentagePPAI * 100) / 100, 1, '.', '');
            } else {
                  $resultPaguPPAI = 0;
                  $resultRPPPAI = 0;
                  $resultPercentagePPAI = 0;
            }

            // Result Chart Output
            if ($allTargetPPAI and $allRP2PPAI) {
                  $resultTargetPPAI = array_sum($allTargetPPAI);
                  $resultRP2PPAI = array_sum($allRP2PPAI);

                  // Result Percentage Pie Chart Output
                  $percentagePPAI2 = ($resultRP2PPAI / $resultTargetPPAI) * 100;
                  $resultPercentagePPAI2 =  number_format(floor($percentagePPAI2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTargetPPAI = 0;
                  $resultRP2PPAI = 0;
                  $resultPercentagePPAI2 = 0;
            }
            foreach ($oneinputs as $key => $item) {
                  $item->bidang == "Umum" ?: '';
            }

            $sisaPPAI = $resultPaguPPAI - $resultRPPPAI;
            ##### end section


            ##### PPA II Section
            // GET Bidang
            $dataPPAII = $oneinputs->where('bidang', 'PPA II')->get();

            // Anggaran
            $allPaguPPAII = [];
            $allRPPPAII = [];

            // Output
            $allTargetPPAII = [];
            $allRP2PPAII = [];

            // Loop data and push to an empty array above
            foreach ($dataPPAII as $data) {
                  array_push($allPaguPPAII, $data['pagu']);
                  array_push($allRPPPAII, $data['rp']);
                  array_push($allTargetPPAII, $data['volume_target']);
                  array_push($allRP2PPAII, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPaguPPAII and $allRPPPAII) {
                  $resultPaguPPAII = array_sum($allPaguPPAII);
                  $resultRPPPAII = array_sum($allRPPPAII);

                  // Result Percentage Pie Chart Anggaran
                  $percentagePPAII = ($resultRPPPAII / $resultPaguPPAII) * 100;
                  $resultPercentagePPAII =  number_format(floor($percentagePPAII * 100) / 100, 1, '.', '');
            } else {
                  $resultPaguPPAII = 0;
                  $resultRPPPAII = 0;
                  $resultPercentagePPAII = 0;
            }

            // Result Chart Output
            if ($allTargetPPAII and $allRP2PPAII) {
                  $resultTargetPPAII = array_sum($allTargetPPAII);
                  $resultRP2PPAII = array_sum($allRP2PPAII);

                  // Result Percentage Pie Chart Output
                  $percentagePPAII2 = ($resultRP2PPAII / $resultTargetPPAII) * 100;
                  $resultPercentagePPAII2 =  number_format(floor($percentagePPAII2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTargetPPAII = 0;
                  $resultRP2PPAII = 0;
                  $resultPercentagePPAII2 = 0;
            }

            $sisaPPAII = $resultPaguPPAII - $resultRPPPAII;
            ##### end section

            ##### PAPK Section
            // GET Bidang
            $dataPAPK = $oneinputs->where('bidang', 'PAPK')->get();

            // Anggaran
            $allPaguPAPK = [];
            $allRPPAPK = [];

            // Output
            $allTargetPAPK = [];
            $allRP2PAPK = [];

            // Loop data and push to an empty array above
            foreach ($dataPAPK as $data) {
                  array_push($allPaguPAPK, $data['pagu']);
                  array_push($allRPPAPK, $data['rp']);
                  array_push($allTargetPAPK, $data['volume_target']);
                  array_push($allRP2PAPK, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPaguPAPK and $allRPPAPK) {
                  $resultPaguPAPK = array_sum($allPaguPAPK);
                  $resultRPPAPK = array_sum($allRPPAPK);

                  // Result Percentage Pie Chart Anggaran
                  $percentagePAPK = ($resultRPPAPK / $resultPaguPAPK) * 100;
                  $resultPercentagePAPK =  number_format(floor($percentagePAPK * 100) / 100, 1, '.', '');
            } else {
                  $resultPaguPAPK = 0;
                  $resultRPPAPK = 0;
                  $resultPercentagePAPK = 0;
            }

            // Result Chart Output
            if ($allTargetPAPK and $allRP2PAPK) {
                  $resultTargetPAPK = array_sum($allTargetPAPK);
                  $resultRP2PAPK = array_sum($allRP2PAPK);

                  // Result Percentage Pie Chart Output
                  $percentagePAPK2 = ($resultRP2PAPK / $resultTargetPAPK) * 100;
                  $resultPercentagePAPK2 =  number_format(floor($percentagePAPK2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTargetPAPK = 0;
                  $resultRP2PAPK = 0;
                  $resultPercentagePAPK2 = 0;
            }

            $sisaPAPK = $resultPaguPAPK - $resultRPPAPK;
            ##### end section

            ##### SKKI Section
            // GET Bidang
            $dataSKKI = $oneinputs->where('bidang', 'SKKI')->get();

            // Anggaran
            $allPaguSKKI = [];
            $allRPSKKI = [];

            // Output
            $allTargetSKKI = [];
            $allRP2SKKI = [];

            // Loop data and push to an empty array above
            foreach ($dataSKKI as $data) {
                  array_push($allPaguSKKI, $data['pagu']);
                  array_push($allRPSKKI, $data['rp']);
                  array_push($allTargetSKKI, $data['volume_target']);
                  array_push($allRP2SKKI, $data['volume_jumlah']);
            }

            // Result Chart Anggaran
            if ($allPaguSKKI and $allRPSKKI) {
                  $resultPaguSKKI = array_sum($allPaguSKKI);
                  $resultRPSKKI = array_sum($allRPSKKI);

                  // Result Percentage Pie Chart Anggaran
                  $percentageSKKI = ($resultRPSKKI / $resultPaguSKKI) * 100;
                  $resultPercentageSKKI =  number_format(floor($percentageSKKI * 100) / 100, 1, '.', '');
            } else {
                  $resultPaguSKKI = 0;
                  $resultRPSKKI = 0;
                  $resultPercentageSKKI = 0;
            }

            // Result Chart Output
            if ($allTargetSKKI and $allRP2SKKI) {
                  $resultTargetSKKI = array_sum($allTargetSKKI);
                  $resultRP2SKKI = array_sum($allRP2SKKI);

                  // Result Percentage Pie Chart Output
                  $percentageSKKI2 = ($resultRP2SKKI / $resultTargetSKKI) * 100;
                  $resultPercentageSKKI2 =  number_format(floor($percentageSKKI2 * 100) / 100, 2, '.', '');
            } else {
                  $resultTargetSKKI = 0;
                  $resultRP2SKKI = 0;
                  $resultPercentageSKKI2 = 0;
            }

            $sisaSKKI = $resultPaguSKKI - $resultRPSKKI;
            $totalPagu = $resultPaguPAPK + $resultPaguSKKI + $resultPaguPPAII + $resultPaguPPAI + $resultPaguUMUM;
            $totalRP = $resultRPPAPK + $resultRPSKKI + $resultRPPPAII + $resultRPPPAI + $resultRPUMUM;
            $totalSisa = $sisaPAPK + $sisaSKKI + $sisaPPAII + $sisaPPAI + $sisaUMUM;
            $totalTarget = $resultTargetPAPK + $resultTargetSKKI + $resultTargetPPAII + $resultTargetPPAI + $resultTargetUMUM;
            $totalRP2 = $resultRP2PAPK + $resultRP2SKKI + $resultRP2PPAII + $resultRP2PPAI + $resultRP2UMUM;

            // $totalPercentage =  ($totalRP2 / $totalTarget) * 100  ;
            // $resultPercentage = number_format(floor($totalPercentage * 100) / 100, 2, '.', '');

            // $totalRpPagu = ($totalRP / $totalPagu) * 100;
            // $resultTotalRpPagu =  number_format(floor($totalRpPagu * 100) / 100, 2, '.', '');

            $urks = Urk::all();
            $panduans = Panduan::all();

            return view('output.index', [
                  'urks' => $urks,
                  'panduans' => $panduans,

                  // UMUM
                  'paguUMUM' => $resultPaguUMUM,
                  'rpUMUM' => $resultRPUMUM,
                  'sisaUMUM' => $sisaUMUM,
                  'percentageUMUM' => $resultPercentageUMUM,

                  // PPA I
                  'paguPPAI' => $resultPaguPPAI,
                  'rpPPAI' => $resultRPPPAI,
                  'sisaPPAI' => $sisaPPAI,
                  'percentagePPAI' => $resultPercentagePPAI,

                  // PPA II
                  'paguPPAII' => $resultPaguPPAII,
                  'rpPPAII' => $resultRPPPAII,
                  'sisaPPAII' => $sisaPPAII,
                  'percentagePPAII' => $resultPercentagePPAII,

                  // PAPK
                  'paguPAPK' => $resultPaguPAPK,
                  'rpPAPK' => $resultRPPAPK,
                  'sisaPAPK' => $sisaPAPK,
                  'percentagePAPK' => $resultPercentagePAPK,

                  // SKKI
                  'paguSKKI' => $resultPaguSKKI,
                  'rpSKKI' => $resultRPSKKI,
                  'sisaSKKI' => $sisaSKKI,
                  'percentageSKKI' => $resultPercentageSKKI,

                  ##### Output Chart Bar and Pie
                  // UMUM
                  'targetUMUM' => $resultTargetUMUM,
                  'rp2UMUM' => $resultRP2UMUM,
                  'percentageUMUM2' => $resultPercentageUMUM2,

                  // PPA I
                  'targetPPAI' => $resultTargetPPAI,
                  'rp2PPAI' => $resultRP2PPAI,
                  'percentagePPAI2' => $resultPercentagePPAI2,

                  // PPA II
                  'targetPPAII' => $resultTargetPPAII,
                  'rp2PPAII' => $resultRP2PPAII,
                  'percentagePPAII2' => $resultPercentagePPAII2,

                  // PAPK
                  'targetPAPK' => $resultTargetPAPK,
                  'rp2PAPK' => $resultRP2PAPK,
                  'percentagePAPK2' => $resultPercentagePAPK2,

                  // SKKI
                  'targetSKKI' => $resultTargetSKKI,
                  'rp2SKKI' => $resultRP2SKKI,
                  'percentageSKKI2' => $resultPercentageSKKI2,

                  // TOP RP MAX
                  'allusermax' => $allusermax,
                  'resultMax5RP' => $resultMax5RP,
                  
                  // TOP RP MIN
                  'allusermin' => $allusermin,
                  'resultMin5RP' => $resultMin5RP,
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
