<?php

namespace App\Http\Resources;

class ConsultationResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public static function toFirebase($params)
    {

        return [
            'userId' => $params['user_id'],
            'email' => $params['user_email'] ?? '',
            'name' => $params['name'] ?? '',
            'adminId' => $params['admin_user_id'] ?? null,
            'adminName' => $params['admin_name'] ?? null,
            'applicatorId' => $params['vendor_user_id'] ?? null,
            'applicatorName' => $params['vendor_name'] ?? null,
            'contact' => $params['contact'] ?? '',
            'address' => $params['street'] ?? '',
            'detail' => $params['description'] ?? '',
            'serviceType' => $param['service_type'] ?? '',
            'budget' => $params['estimated_budget'] ?? 0,
            'photos' => $params['photos'] ?? [],
            'orderNumber' => $params['order_number'] ?? 0,
            'orderStatus' => $params['order_status'] ?? 0,
            'discount' => $params['discount'] ?? 0,
            'commission' => $params['commission'] ?? 0,
            'spkCustomer' => $params['spk_customer'] ?? 0,
            'bookingFee' => $params['booking_fee'] ?? 0,
            'terminCustomer1' => $params['termin_customer_1'] ?? 0,
            'terminCustomer2' => $params['termin_customer_2'] ?? 0,
            'terminCustomer3' => $params['termin_customer_3'] ?? 0,
            'terminCustomer4' => $params['termin_customer_4'] ?? 0,
            'terminCustomer5' => $params['termin_customer_5'] ?? 0,
            'spkVendor' => $params['spk_vendor'] ?? 0,
            'spkVendorNet' => $params['spk_vendor_net'] ?? 0,
            'terminVendor1' => $params['termin_vendor_1'] ?? 0,
            'terminVendor2' => $params['termin_vendor_2'] ?? 0,
            'terminVendor3' => $params['termin_vendor_3'] ?? 0,
            'terminVendor4' => $params['termin_vendor_4'] ?? 0,
            'terminVendor5' => $params['termin_vendor_5'] ?? 0,
            'createdAt' => $params['created_at'] ?? '',
            'updatedAt' => $params['updated_at'] ?? '',
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public static function fromFirebase($params)
    {
        return self::convertFromFirebase($params);
    }

    /**
     * Transform the resource into an array.
     *
     * @param $params
     * @return array
     */
    public static function fromFirebaseArray($params)
    {
        $result = [];
        foreach ($params as $param) {
            array_push($result, self::convertFromFirebase($param));
        }
        return $result;
    }

    private static function convertFromFirebase($param){
        return [
            'id' => $param['id'],
            'user_id' => $param['userId'],
            'user_email' => $param['email'] ?? '',
            'name' => $param['name'] ?? '',
            'admin_user_id' => $param['adminId'] ?? null,
            'admin_name' => $param['adminName'] ?? null,
            'vendor_user_id' => $param['applicatorId'] ?? null,
            'vendor_name' => $param['applicatorName'] ?? null,
            'contact' => $param['contact'] ?? '',
            'street' => $param['address'] ?? '',
            'description' => $param['detail'] ?? '',
            'service_type' => $param['serviceType'] ?? '',
            'estimated_budget' => $param['budget'] ?? 0,
            'photos' => $param['photos'] ?? [],
            'order_number' => $param['orderNumber'] ?? '',
            'order_status' => $param['orderStatus'] ?? '',
            'applicator_discount' => $param['applicatorDiscount'] ?? 0,
            'mitraruma_discount' => $param['mitrarumaDiscount'] ?? 0,
            'mitraruma_material_buy' => $param['mitrarumaMaterialBuy'] ?? 0,
            'commission' => $param['commission'] ?? 0,
            'expense_complain' => $param['expenseComplain'] ?? 0,
            'expense_survey' => $param['expenseSurvey'] ?? 0,
            'expense_design' => $param['expenseDesign'] ?? 0,
            'expense_others' => $param['expenseOthers'] ?? 0,
            'total_expense' => $param['totalExpense'] ?? 0,
            'gmv' => $param['gmv'] ?? 0,
            'notes' => $param['notes'] ?? '',
            'project_value' => $param['projectValue'] ?? 0,
            'spk_customer' => $param['spkCustomer'] ?? 0,
            'booking_fee' => $param['bookingFee'] ?? 0,
            'termin_customer_percentage_1' => $param['terminCustomerPercentage1'] ?? 0,
            'termin_customer_1' => $param['terminCustomer1'] ?? 0,
            'termin_customer_date_1' => $param['terminCustomerDate1'] ?? '',
            'termin_customer_percentage_2' => $param['terminCustomerPercentage2'] ?? 0,
            'termin_customer_2' => $param['terminCustomer2'] ?? 0,
            'termin_customer_date_2' => $param['terminCustomerDate2'] ?? '',
            'termin_customer_percentage_3' => $param['terminCustomerPercentage3'] ?? 0,
            'termin_customer_3' => $param['terminCustomer3'] ?? 0,
            'termin_customer_date_3' => $param['terminCustomerDate3'] ?? '',
            'termin_customer_percentage_4' => $param['terminCustomerPercentage4'] ?? 0,
            'termin_customer_4' => $param['terminCustomer4'] ?? 0,
            'termin_customer_date_4' => $param['terminCustomerDate4'] ?? '',
            'termin_customer_percentage_5' => $param['terminCustomerPercentage5'] ?? 0,
            'termin_customer_5' => $param['terminCustomer5'] ?? 0,
            'termin_customer_date_5' => $param['terminCustomerDate5'] ?? '',
            'termin_customer_percentage_6' => $param['terminCustomerPercentage6'] ?? 0,
            'termin_customer_6' => $param['terminCustomer6'] ?? 0,
            'termin_customer_date_6' => $param['terminCustomerDate6'] ?? '',
            'spk_vendor' => $param['spkVendor'] ?? 0,
            'spk_vendor_net' => $param['spkVendorNet'] ?? 0,
            'termin_vendor_percentage_1' => $param['terminVendorPercentage1'] ?? 0,
            'termin_vendor_1' => $param['terminVendor1'] ?? 0,
            'termin_vendor_date_1' => $param['terminVendorDate1'] ?? '',
            'termin_vendor_percentage_2' => $param['terminVendorPercentage2'] ?? 0,
            'termin_vendor_2' => $param['terminVendor2'] ?? 0,
            'termin_vendor_date_2' => $param['terminVendorDate2'] ?? '',
            'termin_vendor_percentage_3' => $param['terminVendorPercentage3'] ?? 0,
            'termin_vendor_3' => $param['terminVendor3'] ?? 0,
            'termin_vendor_date_3' => $param['terminVendorDate3'] ?? '',
            'termin_vendor_percentage_4' => $param['terminVendorPercentage4'] ?? 0,
            'termin_vendor_4' => $param['terminVendor4'] ?? 0,
            'termin_vendor_date_4' => $param['terminVendorDate4'] ?? '',
            'termin_vendor_percentage_5' => $param['terminVendorPercentage5'] ?? 0,
            'termin_vendor_5' => $param['terminVendor5'] ?? 0,
            'termin_vendor_date_5' => $param['terminVendorDate5'] ?? '',
            'termin_vendor_percentage_6' => $param['terminVendorPercentage6'] ?? 0,
            'termin_vendor_6' => $param['terminVendor6'] ?? 0,
            'termin_vendor_date_6' => $param['terminVendorDate6'] ?? '',
            'retention_payment_date' => $param['retentionPaymentDate'] ?? '',
            'retention_payment' => $param['retentionPayment'] ?? 0,
            'created_at' => $param['createdAt'] ?? '',
            'updated_at' => $param['updatedAt'] ?? '',
        ];
    }
}
