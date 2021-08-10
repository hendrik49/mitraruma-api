<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'chat_room_id' => $this->chat_room_id,
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
            'text' => $this->text ?? '',
        ];;
    }
}
