<?php

namespace App\Http\Resources;

class ChatroomResource
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
            'adminId' => $params['admin_id'] ?? null,
            'applicatorId' => $params['vendor_user_id'] ?? null,
            'userId' => $params['user_id'],
            'consultationId' => $params['consultation_id'],
            'date' => $params['date'] ?? null,
            'imageUrl' => $params['image_url'],
            'name' => $params['name'],
            'isApprove' => $params['is_approve'] ?? null,
            'roomType' => $params['room_type'],
            'status' => $params['status'],
            'text' => $params['text'],
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
            'admin_id' => $param['adminId'],
            'applicator_id' => $param['applicatorId'],
            'user_id' => $param['userId'],
            'consultation_id' => $param['consultationId'] ?? '',
            'date' => $param['date'] ?? '',
            'image_url' => $param['imageUrl'] ?? '',
            'name' => $param['name'] ?? '',
            'is_approve' => $param['isApprove'] ?? '',
            'room_type' => $param['roomType'] ?? '',
            'status' => $param['status'],
            'text' => $param['text'],
        ];
    }
}
