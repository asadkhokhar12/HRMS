<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'notifications' => $this->collection->map(function ($notification) {
                $sender_info=Notification::sender($notification->data['sender_id']);
                return [
                    'id' => $notification->id,
                    'sender' => @$sender_info->name,
                    'sender_id' => @$sender_info->id,

                    'title' => $notification->data['title'],
                    'body' => $notification->data['body'],
                    'image' => $notification->data['image'] ?? uploaded_asset(@base_settings('company_icon')),
                    'date'=>$notification->created_at->diffForHumans(),
                    'slag'=>$notification->data['actionURL']['app'],
                    'read_at' => $notification->read_at,
                    'is_read'=>$notification->read_at ? true : false,
                ];
            })
        ];
    }
}
