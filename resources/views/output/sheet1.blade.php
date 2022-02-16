<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <table border="1" class="table-output-excel">
        <tr>
            <th rowspan="3"><strong>ID</strong></th>
            <th rowspan="3"><strong>Digit</strong></th>
            <th rowspan="3"><strong>KD KRO</strong></th>
            <th rowspan="3"><strong>KD RO</strong></th>
            <th colspan="8"><strong>Cara mencapai realisasi output</strong></th>
            <th rowspan="3"><strong>PAGU</strong></th>
            <th rowspan="3"><strong>RP</strong></th>
            <th rowspan="3"><strong>% CAPAIAN</strong></th>
            <th rowspan="3"><strong>SISA</strong></th>
        </tr>
        <tr>
            <th colspan="8"><strong>Tahun {{ session('tahun') }}</strong></th>
        </tr>
        <tr>
            <th><strong>Target volume</strong></th>
            <th><strong>Satuan</strong></th>
            <th><strong>Capaian volume</strong></th>
            <th><strong>Uraian Laporan</strong></th>
            <th><strong>Nomor Dokumen</strong></th>
            <th><strong>Tanggal</strong></th>
            <th><strong>Jumlah Volume</strong></th>
            <th><strong>RVO (JUMLAH VOLUME)</strong></th>
        </tr>
    
        {{-- start --}}
        @php
            $index = 1;
        @endphp
        @foreach ($oneinput as $key => $one)

            {{-- ini mehitung jumlah row dalam item $two --}}
            @php
                $n = 0;
            @endphp
            @if (!empty($twoinput))
                @foreach ($twoinput as $keytwo => $two)
                    @if ($two->one_input_id == $one->id)
                        @php
                            $n++;
                        @endphp
                    @endif
                @endforeach
            @endif
        
            {{-- baris row --}}
            {{-- one input loop --}}
            <tr>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $index }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->digit }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->kd_kro }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->kd_ro }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->volume_target }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->satuan }}</td>

                @if (!empty($one->TwoInput[0]))
                    <td>{{ !empty($one->TwoInput[0]->volume_capaian) ? $one->TwoInput[0]->volume_capaian : '' }}</td>
                    <td>{{ !empty($one->TwoInput[0]->uraian) ? $one->TwoInput[0]->uraian : '' }}</td>
                    <td>{{ !empty($one->TwoInput[0]->nomor_dokumen) ? $one->TwoInput[0]->nomor_dokumen : '' }}</td>
                    <td>{{ !empty($one->TwoInput[0]->tanggal) ? \Carbon\Carbon::parse($one->TwoInput[0]->tanggal)->format('d-m-Y') : '' }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
    
    
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->volume_jumlah }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->rvo * 100 }}%</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ number_format($one->pagu, 0, '.', '.') }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ number_format($one->rp, 0, '.', '.') }}</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ $one->capaian }}%</td>
                <td {{ ($n != 0) ? "rowspan=$n" : "" }}>{{ number_format($one->sisa, 0, '.', '.') }}</td>
            </tr>
    
            {{-- two input loop --}}
            @if (empty($twoinput))
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            @else
                @foreach ($twoinput as $keytwo => $two)
                    @if (($two->one_input_id == $one->id) && ($two->deleted_at == null))
                        @if ($one->TwoInput->first() == $two)
                            <div class="kosong"></div>
                        @else
                            <tr>
                                <td>{{ $two->volume_capaian }}</td>
                                <td>{{ $two->uraian }}</td>
                                <td>{{ $two->nomor_dokumen }}</td>
                                <td>{{ \Carbon\Carbon::parse($two->tanggal)->format('d-m-Y') }}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
            @php
                $index++;
            @endphp
        @endforeach        
        
    </table>
    
</body>
</html>
