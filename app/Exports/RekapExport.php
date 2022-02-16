<?php

namespace App\Exports;

use App\Models\OneInput;
use App\Models\TwoInput;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;

class RekapExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        if (auth()->user()->role !== 'Monitoring') {
            abort(403);
        }

        // $id = auth()->user()->id;
        $id = (int) substr(url()->current(), -1);

        $oneinputs = OneInput::whereYear('created_at', '=', session('year'))->where('user_id', $id);

        // Sum Volume capaian
        // foreach ($oneinputs as $oneinput) {
        //       $id = OneInput::id;

        //       $input = TwoInput::where('one_input_id', $id)->pluck('volume_capaian')->toArray();
        //       $oneinput = OneInput::find($id);
        //       $sum = array_sum($input);

        //       $oneinput->volume_jumlah = $sum;
        //       $oneinput->update();
        // }

        ##### UMUM Section
        // GET Bidang
        $dataUMUM = $oneinputs->where('bidang', 'Umum')->get();

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
        $dataPPAI =  $oneinputs->where('bidang', 'PPA I')->get();

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
        $dataPAPK =  $oneinputs->where('bidang', 'PAPK')->get();

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
        $dataSKKI =  $oneinputs->where('bidang', 'SKKI')->get();

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

        if ($totalRP2 and $totalTarget) {
                $totalPercentage =  ($totalRP2 / $totalTarget) * 100;
                $resultPercentage = number_format(floor($totalPercentage * 100) / 100, 2, '.', '');
        } else {
                $totalPercentage = 0;
                $resultPercentage = number_format(floor($totalPercentage * 100) / 100, 2, '.', '');
        }

        if ($totalRP and $totalPagu) {
                $totalRpPagu = ($totalRP / $totalPagu) * 100;
                $resultTotalRpPagu =  number_format(floor($totalRpPagu * 100) / 100, 2, '.', '');
        } else {
                $totalRpPagu = 0;
                $resultTotalRpPagu =  number_format(floor($totalRpPagu * 100) / 100, 2, '.', '');
        }


        return view('output.rekapExcel', [
            // Total

            'totalPagu' => $totalPagu,
            'totalRP' => $totalRP,
            'totalSisa' => $totalSisa,
            'totalRpPagu' => $resultTotalRpPagu,
            'totalTarget' => $totalTarget,
            'totalRP2' => $totalRP2,
            'totalPercentage' => $resultPercentage,

            'title' => 'Rekap',
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
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:I2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('A1:I8')->getAlignment()->setVertical(StyleAlignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:I8')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:I2')->getFont()->setSize(16);
                $event->sheet->getStyle("A1:I8")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ]
                ]);
            }
        ];
    }

}
