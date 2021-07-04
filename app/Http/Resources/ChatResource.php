<?php

namespace App\Http\Resources;

class ChatResource
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
            'chat' => $params['chat'],
            'isSystem' => $params['is_system'] ?? false,
            'name' => $params['name'],
            'roomId' => $params['room_id']
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
            'display_name' => $param['name'] ?? '',
            'city' => $param['city'] ?? '',
            'zipcode' => $param['zipcode'] ?? '',
            'street' => $param['address'] ?? '',
            'detail' => $param['description'] ?? '',
            'estimated_budget' => $param['budget'] ?? 0,
            'photos' => $param['photos'] ?? [],
        ];
    }
}
