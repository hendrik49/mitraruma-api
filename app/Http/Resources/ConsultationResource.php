<?php

namespace App\Http\Resources;

use App\Helpers\OrderStatus;

class ConsultationResource
{

    /**
     * @var OrderStatus
     */
    private $orderStatus;

    public function __construct(
        OrderStatus $orderStatus
    )
    {
        $this->orderStatus = $orderStatus;
    }

    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public function toFirebase($params)
    {

        return [
            'userId' => $params['user_id'],
            'email' => $params['user_email'] ?? '',
            'name' => $params['name'] ?? '',
            'adminId' => $params['admin_user_id'] ?? null,
            'adminName' => $params['admin_name'] ?? null,
            'adminEmail' => $params['admin_eamil'] ?? null,
            'applicatorId' => $params['vendor_user_id'] ?? null,
            'applicatorName' => $params['vendor_name'] ?? null,
            'applicatorEmail' => $params['vendor_email'] ?? null,
            'contact' => $params['contact'] ?? '',
            'address' => $params['street'] ?? '',
            'city' => $params['city'] ?? '',
            'detail' => $params['description'] ?? '',
            'serviceType' => $params['service_type'] ?? '',
            'consultationId' => $params['consultation_id'] ?? '',
            'budget' => $params['estimated_budget'] ?? 0,
            'photos' => $params['photos'] ?? [],
            'orderNumber' => $params['order_number'] ?? 0,
            'orderStatus' => $params['order_status'] ?? 0,
            // 'applicatorDiscount' => $params['applicator_discount'] ?? 0,
            // 'mitrarumaDiscount' => $params['mitraruma_discount'] ?? 0,
            // 'mitrarumaMaterialBuy' => $params['mitraruma_material_buy'] ?? 0,
            // 'commission' => $params['commission'] ?? 0,
            // 'expenseComplain' => $params['expense_complain'] ?? 0,
            // 'expenseSurvey' => $params['expense_survey'] ?? 0,
            // 'expenseDesign' => $params['expense_design'] ?? 0,
            // 'expenseOthers' => $params['expense_others'] ?? 0,
            // 'totalExpense' => $params['total_expense'] ?? 0,
            // 'gmv' => $params['gmv'] ?? 0,
            // 'notes' => $params['notes'] ?? '',
            // 'projectValue' => $params['project_value'] ?? 0,
            // 'spkCustomer' => $params['spk_customer'] ?? 0,
            // 'bookingFee' => $params['booking_fee'] ?? 0,
            // 'terminCustomerPercentage1' => $params['termin_customer_percentage_1'] ?? 0,
            // 'terminCustomer1' => $params['termin_customer_1'] ?? 0,
            // 'terminCustomerDate1' => $params['termin_customer_date_1'] ?? '',
            // 'terminCustomerPercentage2' => $params['termin_customer_percentage_2'] ?? 0,
            // 'terminCustomer2' => $params['termin_customer_2'] ?? 0,
            // 'terminCustomerDate2' => $params['termin_customer_date_2'] ?? '',
            // 'terminCustomerPercentage3' => $params['termin_customer_percentage_3'] ?? 0,
            // 'terminCustomer3' => $params['termin_customer_3'] ?? 0,
            // 'terminCustomerDate3' => $params['termin_customer_date_3'] ?? '',
            // 'terminCustomerPercentage4' => $params['termin_customer_percentage_4'] ?? 0,
            // 'terminCustomer4' => $params['termin_customer_4'] ?? 0,
            // 'terminCustomerDate4' => $params['termin_customer_date_4'] ?? '',
            // 'terminCustomerPercentage5' => $params['termin_customer_percentage_5'] ?? 0,
            // 'terminCustomer5' => $params['termin_customer_5'] ?? 0,
            // 'terminCustomerDate5' => $params['termin_customer_date_5'] ?? '',
            // 'terminCustomerPercentage6' => $params['termin_customer_percentage_6'] ?? 0,
            // 'terminCustomer6' => $params['termin_customer_6'] ?? 0,
            // 'terminCustomerDate6' => $params['termin_customer_date_6'] ?? '',
            // 'terminCustomerCount' => $params['termin_customer_count'] ?? 0,
            // 'spkVendor' => $params['spk_vendor'] ?? 0,
            // 'spkVendorNet' => $params['spk_vendor_net'] ?? 0,
            // 'terminVendorPercentage1' => $params['termin_vendor_percentage_1'] ?? 0,
            // 'terminVendor1' => $params['termin_vendor_1'] ?? 0,
            // 'terminVendorDate1' => $params['termin_vendor_date_1'] ?? '',
            // 'terminVendorPercentage2' => $params['termin_vendor_percentage_2'] ?? 0,
            // 'terminVendor2' => $params['termin_vendor_2'] ?? 0,
            // 'terminVendorDate2' => $params['termin_vendor_date_2'] ?? '',
            // 'terminVendorPercentage3' => $params['termin_vendor_percentage_3'] ?? 0,
            // 'terminVendor3' => $params['termin_vendor_3'] ?? 0,
            // 'terminVendorDate3' => $params['termin_vendor_date_3'] ?? '',
            // 'terminVendorPercentage4' => $params['termin_vendor_percentage_4'] ?? 0,
            // 'terminVendor4' => $params['termin_vendor_4'] ?? 0,
            // 'terminVendorDate4' => $params['termin_vendor_date_4'] ?? '',
            // 'terminVendorPercentage5' => $params['termin_vendor_percentage_5'] ?? 0,
            // 'terminVendor5' => $params['termin_vendor_5'] ?? 0,
            // 'terminVendorDate5' => $params['termin_vendor_date_5'] ?? '',
            // 'terminVendorPercentage6' => $params['termin_vendor_percentage_6'] ?? 0,
            // 'terminVendor6' => $params['termin_vendor_6'] ?? 0,
            // 'terminVendorDate6' => $params['termin_vendor_date_6'] ?? '',
            // 'terminVendorCount' => $params['termin_vendor_count'] ?? 0,
            // 'retentionPaymentDate' => $params['retention_payment_date'] ?? '',
            // 'retentionPayment' => $params['retention_payment'] ?? 0,
            'createdAt' => $params['created_at'] ?? '',
            'updatedAt' => $params['updated_at'] ?? '',
            'ratingVendor' => $params['rating_vendor'] ?? 0,
            'ratingAdmin' => $params['rating_admin'] ?? 0,
            'ratingCustomer' => $params['rating_customer'] ?? 0,
            'progress' => $params['progress'] ?? 0,
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public function fromFirebase($params)
    {
        return self::convertFromFirebase($params);
    }

    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public function fromFirebaseArray($params)
    {
        $result = [];
        foreach ($params as $param) {
            array_push($result, self::convertFromFirebase($param));
        }
        return $result;
    }

    private function convertFromFirebase($param){
        return [
            'id' => $param['id'],
            'consultation_id' => $params['consultationId'] ?? '',
            'user_id' => $param['userId'],
            'user_email' => $param['email'] ?? '',
            'name' => $param['name'] ?? '',
            'admin_user_id' => $param['adminId'] ?? null,
            'admin_name' => $param['adminName'] ?? null,
            'admin_email' => $param['adminEmail'] ?? null,
            'vendor_user_id' => $param['applicatorId'] ?? null,
            'vendor_name' => $param['applicatorName'] ?? null,
            'vendor_email' => $param['applicatorEmail'] ?? null,
            'contact' => $param['contact'] ?? '',
            'service_type' => $param['serviceType'] ?? '',
            'street' => $param['address'] ?? '',
            'city' => $param['city'] ?? '',
            'description' => $param['detail'] ?? '',
            'estimated_budget' => $param['budget'] ?? 0,
            'photos' => $param['photos'] ?? [],
            'order_number' => $param['orderNumber'] ?? '',
            'order_status' => $param['orderStatus'] ?? '',
            'order_status_name' =>  $this->orderStatus->getPhaseByCode($param['orderStatus']) ?? '',
            'progress' => $param['progress'] ?? 0,
            // 'applicator_discount' => $param['applicatorDiscount'] ?? 0,
            // 'mitraruma_discount' => $param['mitrarumaDiscount'] ?? 0,
            // 'mitraruma_material_buy' => $param['mitrarumaMaterialBuy'] ?? 0,
            // 'commission' => $param['commission'] ?? 0,
            // 'expense_complain' => $param['expenseComplain'] ?? 0,
            // 'expense_survey' => $param['expenseSurvey'] ?? 0,
            // 'expense_design' => $param['expenseDesign'] ?? 0,
            // 'expense_others' => $param['expenseOthers'] ?? 0,
            // 'total_expense' => $param['totalExpense'] ?? 0,
            // 'gmv' => $param['gmv'] ?? 0,
            // 'notes' => $param['notes'] ?? '',
            // 'project_value' => $param['projectValue'] ?? 0,
            // 'spk_customer' => $param['spkCustomer'] ?? 0,
            // 'booking_fee' => $param['bookingFee'] ?? 0,
            // 'termin_customer_percentage_1' => $param['terminCustomerPercentage1'] ?? 0,
            // 'termin_customer_1' => $param['terminCustomer1'] ?? 0,
            // 'termin_customer_date_1' => $param['terminCustomerDate1'] ?? '',
            // 'termin_customer_percentage_2' => $param['terminCustomerPercentage2'] ?? 0,
            // 'termin_customer_2' => $param['terminCustomer2'] ?? 0,
            // 'termin_customer_date_2' => $param['terminCustomerDate2'] ?? '',
            // 'termin_customer_percentage_3' => $param['terminCustomerPercentage3'] ?? 0,
            // 'termin_customer_3' => $param['terminCustomer3'] ?? 0,
            // 'termin_customer_date_3' => $param['terminCustomerDate3'] ?? '',
            // 'termin_customer_percentage_4' => $param['terminCustomerPercentage4'] ?? 0,
            // 'termin_customer_4' => $param['terminCustomer4'] ?? 0,
            // 'termin_customer_date_4' => $param['terminCustomerDate4'] ?? '',
            // 'termin_customer_percentage_5' => $param['terminCustomerPercentage5'] ?? 0,
            // 'termin_customer_5' => $param['terminCustomer5'] ?? 0,
            // 'termin_customer_date_5' => $param['terminCustomerDate5'] ?? '',
            // 'termin_customer_percentage_6' => $param['terminCustomerPercentage6'] ?? 0,
            // 'termin_customer_6' => $param['terminCustomer6'] ?? 0,
            // 'termin_customer_date_6' => $param['terminCustomerDate6'] ?? '',
            // 'termin_customer_count' => $param['terminCustomerCount'] ?? 0,
            // 'spk_vendor' => $param['spkVendor'] ?? 0,
            // 'spk_vendor_net' => $param['spkVendorNet'] ?? 0,
            // 'termin_vendor_percentage_1' => $param['terminVendorPercentage1'] ?? 0,
            // 'termin_vendor_1' => $param['terminVendor1'] ?? 0,
            // 'termin_vendor_date_1' => $param['terminVendorDate1'] ?? '',
            // 'termin_vendor_percentage_2' => $param['terminVendorPercentage2'] ?? 0,
            // 'termin_vendor_2' => $param['terminVendor2'] ?? 0,
            // 'termin_vendor_date_2' => $param['terminVendorDate2'] ?? '',
            // 'termin_vendor_percentage_3' => $param['terminVendorPercentage3'] ?? 0,
            // 'termin_vendor_3' => $param['terminVendor3'] ?? 0,
            // 'termin_vendor_date_3' => $param['terminVendorDate3'] ?? '',
            // 'termin_vendor_percentage_4' => $param['terminVendorPercentage4'] ?? 0,
            // 'termin_vendor_4' => $param['terminVendor4'] ?? 0,
            // 'termin_vendor_date_4' => $param['terminVendorDate4'] ?? '',
            // 'termin_vendor_percentage_5' => $param['terminVendorPercentage5'] ?? 0,
            // 'termin_vendor_5' => $param['terminVendor5'] ?? 0,
            // 'termin_vendor_date_5' => $param['terminVendorDate5'] ?? '',
            // 'termin_vendor_percentage_6' => $param['terminVendorPercentage6'] ?? 0,
            // 'termin_vendor_6' => $param['terminVendor6'] ?? 0,
            // 'termin_vendor_date_6' => $param['terminVendorDate6'] ?? '',
            // 'termin_vendor_count' => $param['terminVendorCount'] ?? 0,
            // 'retention_payment_date' => $param['retentionPaymentDate'] ?? '',
            // 'retention_payment' => $param['retentionPayment'] ?? 0,
            'created_at' => $param['createdAt'] ?? '',
            'updated_at' => $param['updatedAt'] ?? '',
            'rating_vendor' => $param['ratingVendor'] ?? 0,
            'rating_admin' => $param['ratingAdmin'] ?? 0,
            'rating_customer' => $param['ratingCustomer'] ?? 0
        ];
    }
}
