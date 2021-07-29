<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerConsultationExport implements ShouldAutoSize, WithStyles, WithColumnFormatting, FromArray
{

    /**
     * @var array
     */
    protected $consultations;

    public function __construct(array $consultations)
    {
        $this->consultations = $consultations;
    }


    public function array(): array
    {
        return array_merge($this->header(), $this->data());
    }

    private function header()
    {
        return [
            [
                '', '', '',
                'Term of payment from customer', '', '', '', '', '',
                '', '', '', '',
            ],
            [
                'project description', 'total value project', 'Discount',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4', 'term 5',
                'Updated At', '', '', ''
            ]
        ];
    }

    private function data()
    {
        $dataBody = [];
        foreach ($this->consultations as $consultation) {
            $formatUpdatedAt = str_replace(array('T', 'Z'), array(' ', ''), $consultation['updated_at']);
            array_push($dataBody, [
                'description' => $consultation['description'],
                'estimated_budget' => $consultation['estimated_budget'],
                'discount' => $consultation['discount'] ?? 0,
                'book_1' => $consultation['book_1'] ?? '',
                'termin_customer_1' => $consultation['termin_customer_1'] ?? 0,
                'termin_customer_2' => $consultation['termin_customer_2'] ?? 0,
                'termin_customer_3' => $consultation['termin_customer_3'] ?? 0,
                'termin_customer_4' => $consultation['termin_customer_4'] ?? 0,
                'termin_customer_5' => $consultation['termin_customer_5'] ?? 0,
                'updated_at' => $formatUpdatedAt ?? '',
            ]);
        }
        return $dataBody;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_GENERAL,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_GENERAL,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('D1:I1');
        $lastRow = $sheet->getCellCollection()->getCurrentRow();
        $style = [
            1 => ['font' => ['size' => 12, 'bold' => true]],
            2 => ['font' => ['size' => 12, 'bold' => true]],
        ];

        for ($i=2; $i<= $lastRow; $i++){
            array_push($style, ['font' => ['size' => 12]]);
        }

        return $style;
    }
}