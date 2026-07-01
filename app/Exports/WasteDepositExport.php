<?php

namespace App\Exports;

use App\Models\DepositDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WasteDepositExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Query data dengan Eager Loading agar proses cepat & hemat memory RAM
    public function query()
    {
        $query = DepositDetail::with(['wasteDeposit.user', 'wasteDeposit.dropOffPoint', 'wastePrice.wasteCategory']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        }

        return $query->latest();
    }

    // Header Kolom di Excel
    public function headings(): array
    {
        return [
            'ID Detail',
            'Tanggal Setor',
            'Nama Nasabah',
            'Titik Kumpul (Drop-Off)',
            'Kategori Sampah',
            'Berat Timbangan',
            'Total Nominal',
        ];
    }

    // Mapping Data Kolom demi Kolom
    public function map($row): array
    {
        return [
            '#DTL-' . $row->id,
            $row->created_at->format('d-m-Y H:i'),
            $row->wasteDeposit->user->name ?? 'Masyarakat Umum',
            $row->wasteDeposit->dropOffPoint->name ?? '-',
            $row->wastePrice->wasteCategory->name ?? '-',
            $row->weight_kg . ' Kg',
            'Rp ' . number_format($row->total_price, 0, ',', '.'),
        ];
    }

    // Styling Header agar Menarik & Profesional
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2D333D']]
            ],
        ];
    }
}