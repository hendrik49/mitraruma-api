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
                'Term of payment from customer', '', '', '', '', '',
                'Term of payment from applicator', '', '', '', '', '',
                '', '', '', '', '',
            ],
            [
                'project description', 'total value project', 'Discount',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4', 'term 5',
                'Booking/Design', 'term 1', 'term 2', 'term 3', 'term 4', 'term 5',
                'commission', '', '', '', ''
            ]
        ];
    }

    private function data() {
        $dataBody = [];
        foreach ($this->consultations as $consultation) {
            array_push($dataBody, [
                'description' => $consultation['description'],
                'estimated_budget' => $consultation['estimated_budget'],
                'discount' => $consultation['discount'] ?? '',
                'book_1' => $consultation['book_1'] ?? '',
                'termin_customer_1' => $consultation['termin_customer_1'] ?? '',
                'termin_customer_2' => $consultation['termin_customer_2'] ?? '',
                'termin_customer_3' => $consultation['termin_customer_3'] ?? '',
                'termin_customer_4' => $consultation['termin_customer_4'] ?? '',
                'termin_customer_5' => $consultation['termin_customer_5'] ?? '',
                'book_2' => $consultation['book_2'] ?? '',
                'termin_vendor_1' => $consultation['termin_vendor_1'] ?? '',
                'termin_vendor_2' => $consultation['termin_vendor_2'] ?? '',
                'termin_vendor_3' => $consultation['termin_vendor_3'] ?? '',
                'termin_vendor_4' => $consultation['termin_vendor_4'] ?? '',
                'termin_vendor_5' => $consultation['termin_vendor_5'] ?? '',
                'commission' => $consultation['commission'] ?? '',
            ]);
        }
        return $dataBody;
    }
}