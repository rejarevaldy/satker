<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OneInput;
use App\Models\TwoInput;
use App\Exports\InputExport;
use App\Exports\RekapExport;
use Illuminate\Http\Request;
use App\Exports\InputAllExport;
use App\Exports\RekapAllExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function rekapExport(OneInput $oneinput, User $user)
    {
        if (auth()->user()->role !== 'Monitoring') {
			abort(403);
		}

		$id = (int) substr(url()->current(), -1);

		$oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $id);

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



		// return view('output.rekapExcel', [

		// 		// datas
		// 		'pagu' => $resultPagu,
		// 		'rp' => $resultRP,
		// 		'rp2' => $resultRP2,
		// 		'sisa' => $sisa,
		// 		'percentage' => $resultPercentage,
		// 		'percentage2' => $resultPercentage2,
		// 		'target' => $resultTarget

		// ]);


        return Excel::download(new RekapExport, 'Laporan Rekap ' . session('year') . ' ' . $user->nama . '.xlsx');
    }

    public function rekapAllExport()
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



		// return view('output.rekapExcel', [

		// 		// datas
		// 		'pagu' => $resultPagu,
		// 		'rp' => $resultRP,
		// 		'rp2' => $resultRP2,
		// 		'sisa' => $sisa,
		// 		'percentage' => $resultPercentage,
		// 		'percentage2' => $resultPercentage2,
		// 		'target' => $resultTarget

		// ]);

        return Excel::download(new RekapAllExport, 'Laporan Semua Rekap Monitoring Tahun ' . session('year') . '.xlsx');
    }
    
    public function exportWithAllView()
    {
        // $oneinput = OneInput::all();
        // $twoinput = TwoInput::with('OneInput')->get();

        $role = Auth::user()->role;

        if ($role == 'Monitoring') {
            $oneinputs =  OneInput::whereYear('created_at', '=', session('year'))->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
        } else {
            $user_id = Auth::user()->id;
            $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
        }
        // dd($twoinput);

        // $input = TwoInput::with('OneInput')->get();
        // $oneinput = OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
        // if(!$twoinput) {
        //     dd('empty');
        // }
        // return view('output.sheet1', [
        //     'title' => 'Dashboard',
        //     // 'input' => $input,
        //     'oneinput' => $oneinputs,
        //     'twoinput' => $twoinput
        // ]);

        return Excel::download(new InputAllExport, 'Laporan Realisasi ' . session('year') . ' ' . Auth::user()->role . '.xlsx');
    }

    public function exportWithView()
    {
        // $oneinput = OneInput::all();
        // $twoinput = TwoInput::with('OneInput')->get();

        $role = Auth::user()->role;
        $id = (int) substr(url()->current(), -1);
        
        if ($role == 'Monitoring') {
            $oneinputs =  OneInput::whereYear('created_at', '=', session('year'))->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
        } else {
            $user_id = Auth::user()->id;
            $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $id)->get();
        //     $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->get();
            $twoinput = TwoInput::whereYear('created_at', session('year'))->get();
        }
        // dd($twoinput);

        // $input = TwoInput::with('OneInput')->get();
        // $oneinput = OneInput::whereYear('created_at', session('year'))->where('user_id', $user_id)->get();
        // if(!$twoinput) {
        //     dd('empty');
        // }
        // return view('output.sheet1', [
        //     'title' => 'Dashboard',
        //     // 'input' => $input,
        //     'oneinput' => $oneinputs,
        //     'twoinput' => $twoinput
        // ]);

        return Excel::download(new InputExport, 'Laporan Realisasi ' . session('year') . ' ' . Auth::user()->role . '.xlsx');
    }
}
