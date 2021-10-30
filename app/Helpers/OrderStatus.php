<?php


namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\Date;

class OrderStatus
{

  private $phase = [
    "Pre-Purchase" => [],
    "Design Phase" => [],
    "Construction Phase" => [],
    "Project Started" => [],
    "Project Ended" => []
  ];

  public $data = '
            {
              "110": {
                "activity": "Start of Conversation",
                "action": "Start of Conversation",
                "phase": "Pre-Purchase",
                "type":"general",
                "by": "admin"
              },
              "120": {
                "activity": "Detail Project Uploaded",
                "action": "Detail Project Uploaded",
                "phase": "Pre-Purchase",
                "type":"general",
                "by": "admin"
              },
              "130": {
                "activity": "Selected Applicator join the conversation",
                "action": "Selected Applicator join the conversation",
                "phase": "Pre-Purchase",
                "type":"general",
                "by": "admin"
              },
              "140": {
                "activity": "Quotation Uploaded",
                "action": "Upload Quotation",
                "phase": "Pre-Purchase",
                "type":"document",
                "by": "vendor"
              },
              "160": {
                "activity": "Booking Fee Paid",
                "action": "Pay Booking Fee",
                "phase": "Pre-Purchase",
                "type":"payment",
                "by": "customer"
              },
              "170": {
                "activity": "Create a Schedule",
                "action": "Create a Schedule",
                "phase": "Pre-Purchase",
                "type":"schedule",
                "by": ""
              },
              "210": {
                "activity": "Build of Quantity (BOQ) Uploaded",
                "action": "Upload Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "type":"document",
                "by": "vendor"
              },
              "220": {
                "activity": "Revision of Build of Quantity (BOQ) Uploaded",
                "action": "Upload Revision Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "type":"document",
                "by": "vendor"
              },
              "230": {
                "activity": "Final Revision of Build of Quantity (BOQ) Uploaded",
                "action": "Upload Final Revision Build of Quantity (BOQ)",
                "phase": "Design Phase",
                "type":"document",
                "by": "vendor"
              },
              "240": {
                "activity": "Create a Schedule",
                "action": "Create a Schedule",
                "phase": "Design Phase",
                "type":"schedule",
                "by": ""
              },
              "310": {
                "activity": "Draft Contract Uploaded",
                "action": "Upload Draft Contract",
                "phase": "Construction Phase",
                "type":"document",
                "by": "admin"
              },
              "320": {
                "activity": "Signed Contract Uploaded by Customer",
                "action": "Upload Signed Contract",
                "phase": "Construction Phase",
                "type":"document",
                "by": "customer"
              },
              "321": {
                "activity": "Signed Contract Uploaded by Applicator",
                "action": "Upload Signed Contract",
                "phase": "Construction Phase",
                "type":"document",
                "by": "vendor"
              },
              "330": {
                "activity": "First Payment Paid by Customer",
                "action": "Pay First Payment",
                "phase": "Construction Phase",
                "type":"payment",
                "by": "customer"
              },
              "331": {
                "activity": "First Payment Paid by Admin",
                "action": "Pay First Payment",
                "phase": "Construction Phase",
                "type":"payment",
                "by": "admin",
                "hidden": "customer"
              },
              "340": {
                "activity": "Create a Schedule",
                "action": "Create a Schedule",
                "phase": "Construction Phase",
                "type":"schedule",
                "by": ""
              },
              "410": {
                "activity": "Project Has Started and Upload Progress Checklist",
                "action": "Upload Progress Checklist",
                "phase": "Project Started",
                "type":"general",
                "by": "vendor"
              },
              "420": {
                "activity": "Project 50% WIP",
                "action": "Upload Progress 50%",
                "phase": "Project Started",
                "type":"document",
                "by": "vendor"
              },
              "430": {
                "activity": "Second Payment Paid by Customer",
                "action": "Pay Second Payment",
                "phase": "Project Started",
                "type":"payment",
                "by": "customer"
              },
              "431": {
                "activity": "Second Payment Paid by Admin",
                "action": "Pay Second Payment",
                "phase": "Project Started",
                "type":"payment",
                "by": "admin",
                "hidden": "customer"
              },
              "440": {
                "activity": "Acceptance to Continue The Project",
                "action": "Accept & Continue Project",
                "phase": "Project Started",
                "type":"general",
                "by": "customer"
              },
              "450": {
                "activity": "Project 70% WIP",
                "action": "Upload Progress 70%",
                "type":"document",
                "phase": "Project Started",
                "by": "vendor"
              },
              "460": {
                "activity": "Last Payment Paid by Customer",
                "action": "Pay Last Payment",
                "phase": "Project Started",
                "type":"payment",
                "by": "customer"
              },
              "470": {
                "activity": "Third Payment Paid by Admin",
                "action": "Pay Third Payment",
                "phase": "Project Started",
                "type":"payment",
                "by": "admin",
                "hidden": "customer"
              },
              "480": {
                "activity": "Acceptance to Continue The Project",
                "action": "Accept & Continue Project",
                "phase": "Project Started",
                "type":"general",
                "by": "customer"
              },
              "490": {
                "activity": "Create a Schedule",
                "action": "Create a Schedule",
                "phase": "Project Started",
                "type":"schedule",
                "by": ""
              },
              "510": {
                "activity": "Project 100% Finished",
                "action": "Upload Progress 100%",
                "phase": "Project Ended",
                "type":"general",
                "by": "vendor"
              },
              "520": {
                "activity": "Acceptance and Check List to Ended The Project",
                "action": "Accept & End The Project",
                "phase": "Project Ended",
                "type":"general",
                "by": "customer"
              },
              "530": {
                "activity": "Last Payment Paid by Admin",
                "action": "Pay Last Payment",
                "phase": "Project Ended",
                "by": "admin",
                "type":"payment",
                "hidden": "customer"
              },
              "540": {
                "activity": "Feedback and Ratings",
                "action": "Give Feedback and Ratings",
                "phase": "Project Ended",
                "type":"general",
                "by": "customer"
              },
              "550": {
                "activity": "Create a Schedule",
                "action": "Create a Schedule",
                "phase": "Project Ended",
                "type":"schedule",
                "by": ""
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

  public function getActivityByCode($code)
  {
    $code = $code == 'pre-purchase' ? '120' : $code;
    $orderStatuses = json_decode($this->data, true);
    return isset($orderStatuses[$code]) ? $orderStatuses[$code]['activity'] : '';
  }

  public function getConsultationStatus($code, $userType = 'customer')
  {
    $phase = $this->phase;
    $orderStatuses = json_decode($this->data, true);
    foreach ($orderStatuses as $key => $data) {
      if ((int) $key >= $code && $key != 120) {
        if ($data['by'] == '' || $data['by'] == $userType) {
          $objectData = $data;
          $objectData['code'] = $key;
          array_push($phase[$data['phase']], $objectData);
        }
      }
    }
    return $phase;
  }

  public function getConsultationStatusByName($name, $userType = 'customer')
  {
    $phase = array();
    $phase['phase'] = $name;
    $orderStatuses = json_decode($this->data, true);
    foreach ($orderStatuses as $key => $data) {
      if ($data['phase'] == $name && ($data['by'] == '' || $userType == $data['by'])) {
        $objectData = $data;
        $objectData['code'] = $key;
        $phase['list'][] = $objectData;
        // array_push($phase[$data['phase']], $objectData);
      }
    }
    return $phase;
  }

  public function getOrderStatusByCode($code)
  {
    $orderStatuses = json_decode($this->data, true);
    return $orderStatuses[$code];
  }

  public function initOrderStatus()
  {
    $phase  = $this->getPhase();
    $newOrderStatus = $this->getOrderStatusByCode(110);
    array_push($phase[$newOrderStatus['phase']], ["activity" => $newOrderStatus['activity'], 'type' => 'general', 'file' => '', 'createdAt' => Carbon::now()->format('Y-m-d\TH:i:s\Z')]);

    $newOrderStatus = $this->getOrderStatusByCode(120);
    array_push($phase[$newOrderStatus['phase']], ["activity" => $newOrderStatus['activity'], 'type' => 'general', 'file' => '', 'createdAt' => Carbon::now()->format('Y-m-d\TH:i:s\Z')]);

    $newStatus = [];
    foreach ($phase as $keyPhase => $valuePhase) {
      $data = [];
      $data['phase'] = $keyPhase;
      $data['list'] = $valuePhase;
      $data['active'] = false;
      if (sizeof($valuePhase) > 0) {
        $data['active'] = true;
      }
      array_push($newStatus, $data);
    }
    $res['data'] = $newStatus;
    return $res;
  }

  public function updateOrderStatusByCode($curPhase, $params)
  {
    $phase  = $curPhase;
    $newOrderStatus = $this->getOrderStatusByCode($params['order_status']);
    foreach ($phase['data'] as $keyPhase => $valuePhase) {
      if ($valuePhase['phase'] == $newOrderStatus['phase']) {
        $data = [];
        $data['activity'] = $newOrderStatus['activity'];
        if ($params['type'] == "schedule")
          $data['activity'] = $newOrderStatus['activity'] . ": " . $params['title'] ?? '' . " from " . $params['start_date'] ?? '' . " - " . $params['end_date'] ?? '';
        $data['createdAt'] = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $data['file'] = isset($params['file']) ? $params['file'] : null;
        $data['type'] = $params['type'];
        $data['location'] = isset($params['location']) ? $params['location'] : "";
        $data['link'] = isset($params['link']) ? $params['link'] : "";
        $data['paymentLink'] = isset($params['payment_link']) ? $params['payment_link'] : null;
        $data['by'] = $params['user_jwt_type'];

        $phase['data'][$keyPhase]['list'][] = $data;
      }
      if ($params['order_status'] == 160) {
        $phase['data'][1]['active'] = true;
        //design phase
      }
      if ($params['order_status'] == 230) {
        $phase['data'][2]['active'] = true;
        //constrocution phase
      }
      if ($params['order_status'] == 331) {
        $phase['data'][3]['active'] = true;
        //constrocution phase
      }
      if ($params['order_status'] == 480) {
        $phase['data'][4]['active'] = true;
      }
    }
    return $phase;
  }
}
