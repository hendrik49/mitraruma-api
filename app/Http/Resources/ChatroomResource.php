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
            'adminId' => $params['admin_user_id'] ?? null,
            'applicatorId' => $params['vendor_user_id'] ?? null,
            'userId' => $params['user_id'] ?? null,
            'consultationId' => $params['consultation_id'],
            'roomId' => $params['room_id'],
            'date' => $params['date'] ?? null,
            'imageUrl' => $params['image_url'],
            'name' => $params['name'] ?? "",
            'isApprove' => $params['is_approve'] ?? false,
            'roomType' => $params['room_type'],
            'status' => $params['status'],
            'text' => $params['text'] ?? "",
            'consultationDescription' => $params['consultation_description'] ?? "",
            'createdAt' => $params['created_at'] ?? "",
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
            'admin_user_id' => $param['adminId'] ?? null,
            'vendor_user_id' => $param['applicatorId'] ?? null,
            'user_id' => $param['userId'] ?? null,
            'consultation_id' => $param['consultationId'] ?? '',
            'room_id' => $param['roomId'] ?? '',
            'date' => $param['date'] ?? '',
            'image_url' => $param['imageUrl'] ?? '',
            'name' => $param['name'] ?? '',
            'is_approve' => $param['isApprove'] ?? false,
            'room_type' => $param['roomType'] ?? '',
            'status' => $param['status'] ?? '',
            'text' => $param['text'] ?? '',
            'consultation_description' => $param['consultationDescription'] ?? '',
            'created_at' => $param['createdAt'] ?? '',
        ];
    }
}
