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

        return view('output.rekapExcel', [
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:H2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('A1:H3')->getAlignment()->setVertical(StyleAlignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:H2')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:H2')->getFont()->setSize(16);
                $event->sheet->getStyle("A1:H3")->applyFromArray([
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
