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
            'budget' => $params['estimated_budget'] ?? 0,
            'photos' => $params['photos'] ?? [],
            'orderNumber' => $params['order_number'] ?? 0,
            'orderStatus' => $params['order_status'] ?? 0,
            'terminCustomer1' => $params['termin_customer_1'] ?? 0,
            'terminCustomer2' => $params['termin_customer_2'] ?? 0,
            'terminCustomer3' => $params['termin_customer_3'] ?? 0,
            'terminCustomer4' => $params['termin_customer_4'] ?? 0,
            'terminCustomer5' => $params['termin_customer_5'] ?? 0,
            'terminVendor1' => $params['termin_vendor_1'] ?? 0,
            'terminVendor2' => $params['termin_vendor_2'] ?? 0,
            'terminVendor3' => $params['termin_vendor_3'] ?? 0,
            'terminVendor4' => $params['termin_vendor_4'] ?? 0,
            'terminVendor5' => $params['termin_vendor_5'] ?? 0,
            'createdAt' => $params['created_at'] ?? '',
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
            'vendor_user_id' => $param['vendorId'] ?? null,
            'vendor_name' => $param['vendorName'] ?? null,
            'contact' => $param['contact'] ?? '',
            'street' => $param['address'] ?? '',
            'description' => $param['detail'] ?? '',
            'estimated_budget' => $param['budget'] ?? 0,
            'photos' => $param['photos'] ?? [],
            'order_number' => $param['orderNumber'] ?? '',
            'order_status' => $param['orderStatus'] ?? '',
            'termin_customer_1' => $param['terminCustomer1'] ?? '',
            'termin_customer_2' => $param['terminCustomer2'] ?? '',
            'termin_customer_3' => $param['terminCustomer3'] ?? '',
            'termin_customer_4' => $param['terminCustomer4'] ?? '',
            'termin_customer_5' => $param['terminCustomer5'] ?? '',
            'termin_vendor_1' => $param['terminVendor1'] ?? '',
            'termin_vendor_2' => $param['terminVendor2'] ?? '',
            'termin_vendor_3' => $param['terminVendor3'] ?? '',
            'termin_vendor_4' => $param['terminVendor4'] ?? '',
            'termin_vendor_5' => $param['terminVendor5'] ?? '',
            'created_at' => $param['createdAt'] ?? '',
        ];
    }
}
