<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ConsultationExport implements FromArray
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
        return array_merge($this->header(),$this->data());
    }

    private function header() {
        return [
            [
                '', '', '',
                'Term of payment from customer', '', '', '', '',
                'Term of payment from applicator', '', '', '', '',
                'Commission', '', '', '', '',
            ],
            [
                'project description', 'total value project', 'Discount',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4'
            ]
        ];
    }

    private function data() {
        $dataBody = [];
        foreach ($this->consultations as $consultation) {
            array_push($dataBody, [
                'description' => $consultation['description'],
                'estimated_budget' => $consultation['estimated_budget'],
                'estimated_budget' => $consultation['estimated_budget'],
                'discount' => $consultation['discount'] ?? '',
            ]);
        }
        return $dataBody;
    }
}