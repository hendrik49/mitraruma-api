<?php


namespace App\Helpers;

use Carbon\Carbon;

class OrderStatus
{

    private $phase = [
        "Pre-Purchase" => [],
        "Design Phase" => [],
        "Construction Phase" => [],
        "Project Started" => [],
        "Project Ended" => []
    ];

    private $data = '
            {
              "110": {
                "activity": "Start of Conversation",
                "action": "Start of Conversation",
                "phase": "Pre-Purchase",
                "by": ""
              },
              "120": {
                "activity": "Detail Project Uploaded",
                "action": "Detail Project Uploaded",
                "phase": "Pre-Purchase",
                "by": "customer"
              },
              "130": {
                "activity": "Selected Applicator join the conversation",
                "action": "Selected Applicator join the conversation",
                "phase": "Pre-Purchase",
                "by": ""
              },
              "140": {
                "activity": "Quotation Uploaded",
                "action": "Upload Quotation",
                "phase": "Pre-Purchase",
                "by": "vendor"
              },
              "160": {
                "activity": "Booking Fee Paid",
                "action": "Pay Booking Fee",
                "phase": "Pre-Purchase",
                "by": "customer"
              },
              "210": {
                "activity": "Build of Quantity (BOQ) Uploaded",
                "action": "Upload Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "by": "vendor"
              },
              "220": {
                "activity": "Revision of Build of Quantity (BOQ) Uploaded",
                "action": "Upload Revision Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "by": "vendor"
              },
              "230": {
                "activity": "Final Revision of Build of Quantity (BOQ) Uploaded",
                "action": "Upload Final Revision Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "by": "vendor"
              },
              "310": {
                "activity": "Draft Contract Uploaded",
                "action": "Upload Draft Contract",
                "phase": "Construction Phase",
                "by": "admin"
              },
              "320": {
                "activity": "Signed Contract Uploaded by Customer",
                "action": "Upload Signed Contract",
                "phase": "Construction Phase",
                "by": "customer"
              },
              "321": {
                "activity": "Signed Contract Uploaded by Applicator",
                "action": "Upload Signed Contract",
                "phase": "Construction Phase",
                "by": "vendor"
              },
              "330": {
                "activity": "First Payment Paid by Customer",
                "action": "Pay First Payment",
                "phase": "Construction Phase",
                "by": "customer"
              },
              "331": {
                "activity": "First Payment Paid by Admin",
                "action": "Pay First Payment",
                "phase": "Construction Phase",
                "by": "admin",
                "hidden": "customer"
              },
              "410": {
                "activity": "Project Has Started",
                "action": "Upload Progress Checklist",
                "phase": "Project Started",
                "by": "vendor"
              },
              "420": {
                "activity": "Project 50% WIP",
                "action": "Upload Progress 50%",
                "phase": "Project Started",
                "by": "vendor"
              },
              "430": {
                "activity": "Second Payment Paid by Customer",
                "action": "Pay Second Payment",
                "phase": "Project Started",
                "by": "customer"
              },
              "431": {
                "activity": "Second Payment Paid by Admin",
                "action": "Pay Second Payment",
                "phase": "Project Started",
                "by": "admin",
                "hidden": "customer"
              },
              "440": {
                "activity": "Acceptance to Continue The Project",
                "action": "Accept & Continue Project",
                "phase": "Project Started",
                "by": "customer"
              },
              "450": {
                "activity": "Project 70% WIP",
                "action": "Upload Progress 70%",
                "phase": "Project Started",
                "by": "vendor"
              },
              "460": {
                "activity": "Last Payment Paid by Customer",
                "action": "Pay Last Payment",
                "phase": "Project Started",
                "by": "customer"
              },
              "470": {
                "activity": "Third Payment Paid by Admin",
                "action": "Pay Third Payment",
                "phase": "Project Started",
                "by": "admin",
                "hidden": "customer"
              },
              "480": {
                "activity": "Acceptance to Continue The Project",
                "action": "Accept & Continue Project",
                "phase": "Project Started",
                "by": "customer"
              },
              "510": {
                "activity": "Project 100% Finished",
                "action": "Upload Progress 100%",
                "phase": "Project Ended",
                "by": "vendor"
              },
              "520": {
                "activity": "Acceptance and Check List to Ended The Project",
                "action": "Accept & End The Project",
                "phase": "Project Ended",
                "by": "customer"
              },
              "530": {
                "activity": "Last Payment Paid by Admin",
                "action": "Pay Last Payment",
                "phase": "Project Ended",
                "by": "admin",
                "hidden": "customer"
              },
              "540": {
                "activity": "Feedback and Ratings",
                "action": "Give Feedback and Ratings",
                "phase": "Project Ended",
                "by": "customer"
              }
            }';

    public function getPhase()
    {
        return $this->phase;
    }

    public function getPhaseByCode($code)
    {

        $orderStatuses = json_decode($this->data, true);
        return isset($orderStatuses[$code]) ? $orderStatuses[$code]['phase'] : '';

    }

    public function getConsultationStatus($code, $userType = 'customer')
    {
        $phase = $this->phase;
        $orderStatuses = json_decode($this->data, true);
        foreach($orderStatuses as $key => $data) {
            if((int) $key >= $code && $key != 120) {
                if($data['by'] == '' || $data['by'] == $userType) {
                    $objectData = $data;
                    $objectData['code'] = $key;
                    array_push($phase[$data['phase']], $objectData);
                }
            }
        }
        return $phase;

    }

    public function getOrderStatusByCode($code)
    {
        $orderStatuses = json_decode($this->data, true);
        return $orderStatuses[$code];
    }

    public function initOrderStatus(){
        $phase  = $this->getPhase();
        $newOrderStatus = $this->getOrderStatusByCode(110);
        array_push($phase[$newOrderStatus['phase']], ["activity" => $newOrderStatus['activity'], 'createdAt' => Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z')]);
        $newStatus = [];
        foreach ($phase as $keyPhase => $valuePhase) {
            $data = [];
            $data['phase'] = $keyPhase;
            $data['list'] = $valuePhase;
            $data['active'] = false;
            if(sizeof($valuePhase) > 0) {
                $data['active'] = true;
            }
            array_push($newStatus, $data);
        }
        return $newStatus;
    }

}