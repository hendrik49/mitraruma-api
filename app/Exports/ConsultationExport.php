<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Helpers\Date;

class ConsultationExport implements ShouldAutoSize, WithStyles, WithColumnFormatting, FromArray
{

    /**
     * @var array
     */
    protected $consultations;

    /**
     * @var Date
     */
    private $date;

    public function __construct(array $consultations)
    {
        $this->consultations = $consultations;
        $this->date = new Date();
    }


    public function array(): array
    {
        return array_merge($this->header(), $this->data());
    }

    private function header()
    {
        return [
            [
                'Project Code', 'Customer ID', 'Customer Name', 'Area', 'Service Type', 'Project Description', 'Current Work Status', 'Inquiry date', 'Survey date', 'Quotation'
                , 'Design', 'Project Start Date', 'Handover Date', 'Project End Date', 'Project Value', 'SPK Value Customer', 'SPK Value Applicator', 'SPK Value Applicator - NET'
                , 'Applicator Discount', 'Mitraruma Discount', 'Material Buy at Mitraruma', 'Commission', 'Expense - Complain Handling'
                , 'Expense - Survey', 'Expense - Design', 'Expense - Other', 'Total Expense', 'GMV', 'Project Notes'
                , 'Term of payment from customer', 'Booking Fee', '1st incoming payment date', '', '2nd incoming payment date', '', '3rd incoming payment date', '', '4th incoming payment date', '', '5th incoming payment date', '', '6th incoming payment date', ''
                , 'Term of payment from applicator', '1st outgoing payment date', '', '2nd outgoing payment date', '', '3rd outgoing payment date', '', '4th outgoing payment date', '', '5th outgoing payment date', '', '6th outgoing payment date', ''
                , 'Retention Payment Date'
            ]
        ];
    }

    private function formatDate($data) {
        return str_replace(array('T', 'Z'), array(' ', ''), $data);
    }

    private function data()
    {
        $dataBody = [];
        foreach ($this->consultations as $consultation) {

            $formatTerminCustomerPayment  = '';
            for ($i=1; $i<=6; $i++) {
                $formatTerminCustomerPayment .= $consultation["termin_customer_percentage_$i"]."%, ";
            }
            $formatTerminVendorPayment  = '';
            for ($i=1; $i<=6; $i++) {
                $formatTerminVendorPayment .= $consultation["termin_vendor_percentage_$i"]."%, ";
            }

            array_push($dataBody, [
                'order_number' => $consultation['order_number'],
                'user_id' => $consultation['user_id'],
                'name' => $consultation['name'],
                'street' => $consultation['street'] ?? '',
                'service_type' => $consultation['service_type'] ?? '',
                'description' => $consultation['description'] ?? '',
                'order_status_name' => $consultation['order_status_name'] ?? '',
                'inquiry_date' => $this->date->readableDateFirebase($consultation['inquiry_date'] ?? ''),
                'survey_date' => $this->date->readableDateFirebase($consultation['survey_date'] ?? ''),
                'quotation' => $this->date->readableDateFirebase($consultation['quotation'] ?? ''),
                'design' => $this->date->readableDateFirebase($consultation['design'] ?? ''),
                'project_start_date' => $this->date->readableDateFirebase($consultation['project_start_date'] ?? ''),
                'handover_date' => $this->date->readableDateFirebase($consultation['handover_date'] ?? ''),
                'project_end_date' => $this->date->readableDateFirebase($consultation['project_end_date'] ?? ''),
                'project_value' => $consultation['project_value'] ?? 0,
                'spk_customer' => $consultation['spk_customer'] ?? 0,
                'spk_vendor' => $consultation['spk_vendor'] ?? 0,
                'spk_vendor_net' => $consultation['spk_vendor_net'] ?? 0,
                'applicator_discount' => $consultation['applicator_discount'] ?? 0,
                'mitraruma_discount' => $consultation['mitraruma_discount'] ?? 0,
                'mitraruma_material_buy' => $consultation['mitraruma_material_buy'] ?? 0,
                'commission' => $consultation['commission'] ?? 0,
                'expense_complain' => $consultation['expense_complain'] ?? 0,
                'expense_survey' => $consultation['expense_survey'] ?? 0,
                'expense_design' => $consultation['expense_design'] ?? 0,
                'expense_others' => $consultation['expense_others'] ?? 0,
                'total_expense' => $consultation['total_expense'] ?? 0,
                'gmv' => $consultation['gmv'] ?? 0,
                'notes' => $consultation['notes'] ?? '',
                'termin_customer_payment' => $formatTerminCustomerPayment,
                'booking_fee' => $consultation['booking_fee'] ?? 0,
                'termin_customer_date_1' => $this->date->readableDateFirebase($consultation['termin_customer_date_1']),
                'termin_customer_1' => $consultation['termin_customer_1'] ?? 0,
                'termin_customer_date_2' => $this->date->readableDateFirebase($consultation['termin_customer_date_2']),
                'termin_customer_2' => $consultation['termin_customer_2'] ?? 0,
                'termin_customer_date_3' => $this->date->readableDateFirebase($consultation['termin_customer_date_3']),
                'termin_customer_3' => $consultation['termin_customer_3'] ?? 0,
                'termin_customer_date_4' => $this->date->readableDateFirebase($consultation['termin_customer_date_4']),
                'termin_customer_4' => $consultation['termin_customer_4'] ?? 0,
                'termin_customer_date_5' => $this->date->readableDateFirebase($consultation['termin_customer_date_5']),
                'termin_customer_5' => $consultation['termin_customer_5'] ?? 0,
                'termin_customer_date_6' => $this->date->readableDateFirebase($consultation['termin_customer_date_6']),
                'termin_customer_6' => $consultation['termin_customer_6'] ?? 0,
                'termin_vendor_payment' => $formatTerminVendorPayment,
                'termin_vendor_date_1' => $this->date->readableDateFirebase($consultation['termin_vendor_date_1']),
                'termin_vendor_1' => $consultation['termin_vendor_1'] ?? 0,
                'termin_vendor_date_2' => $this->date->readableDateFirebase($consultation['termin_vendor_date_2']),
                'termin_vendor_2' => $consultation['termin_vendor_2'] ?? 0,
                'termin_vendor_date_3' => $this->date->readableDateFirebase($consultation['termin_vendor_date_3']),
                'termin_vendor_3' => $consultation['termin_vendor_3'] ?? 0,
                'termin_vendor_date_4' => $this->date->readableDateFirebase($consultation['termin_vendor_date_4']),
                'termin_vendor_4' => $consultation['termin_vendor_4'] ?? 0,
                'termin_vendor_date_5' => $this->date->readableDateFirebase($consultation['termin_vendor_date_5']),
                'termin_vendor_5' => $consultation['termin_vendor_5'] ?? 0,
                'termin_vendor_date_6' => $this->date->readableDateFirebase($consultation['termin_vendor_date_6']),
                'termin_vendor_6' => $consultation['termin_vendor_6'] ?? 0,
                'retention_payment_date' => $this->date->readableDateFirebase($consultation['retention_payment_date']),
                'retention_payment' => $consultation['retention_payment'] ?? 0,
            ]);
        }
        return $dataBody;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_GENERAL,
            'C' => NumberFormat::FORMAT_GENERAL,
            'D' => NumberFormat::FORMAT_GENERAL,
            'E' => NumberFormat::FORMAT_GENERAL,
            'F' => NumberFormat::FORMAT_GENERAL,
            'G' => NumberFormat::FORMAT_GENERAL,
            'H' => NumberFormat::FORMAT_GENERAL,
            'I' => NumberFormat::FORMAT_GENERAL,
            'J' => NumberFormat::FORMAT_GENERAL,
            'K' => NumberFormat::FORMAT_GENERAL,
            'L' => NumberFormat::FORMAT_GENERAL,
            'M' => NumberFormat::FORMAT_GENERAL,
            'N' => NumberFormat::FORMAT_GENERAL,
            'O' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'P' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'Q' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'R' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'S' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'T' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'U' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'V' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'W' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'X' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'Y' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'Z' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AA' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AB' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AC' => NumberFormat::FORMAT_GENERAL,
            'AD' => NumberFormat::FORMAT_GENERAL,
            'AE' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AF' => NumberFormat::FORMAT_GENERAL,
            'AG' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AH' => NumberFormat::FORMAT_GENERAL,
            'AI' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AJ' => NumberFormat::FORMAT_GENERAL,
            'AK' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AL' => NumberFormat::FORMAT_GENERAL,
            'AM' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AN' => NumberFormat::FORMAT_GENERAL,
            'AO' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AP' => NumberFormat::FORMAT_GENERAL,
            'AQ' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AR' => NumberFormat::FORMAT_GENERAL,
            'AS' => NumberFormat::FORMAT_GENERAL,
            'AT' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AU' => NumberFormat::FORMAT_GENERAL,
            'AV' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AW' => NumberFormat::FORMAT_GENERAL,
            'AX' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'AY' => NumberFormat::FORMAT_GENERAL,
            'AZ' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'BA' => NumberFormat::FORMAT_GENERAL,
            'BB' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'BC' => NumberFormat::FORMAT_GENERAL,
            'BD' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'BE' => NumberFormat::FORMAT_GENERAL,
            'BF' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getCellCollection()->getCurrentRow();
        $style = [
            1 => ['font' => ['size' => 12, 'bold' => true]],
        ];

        for ($i=2; $i<= $lastRow; $i++){
            array_push($style, ['font' => ['size' => 12]]);
        }

        return $style;
    }
}