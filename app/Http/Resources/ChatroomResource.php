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
            'userId' => $params['user_id'],
            'email' => $params['user_email'] ?? '',
            'name' => $params['display_name'] ?? '',
            'city' => $params['city'] ?? '',
            'zipcode' => $params['zipcode'] ?? '',
            'address' => $params['street'] ?? '',
            'detail' => $params['description'] ?? '',
            'budget' => $params['estimated_budget'] ?? 0,
            'photos' => $params['photos'] ?? [],
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
