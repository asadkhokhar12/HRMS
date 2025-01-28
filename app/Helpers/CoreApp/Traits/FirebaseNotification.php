<?php

namespace App\Helpers\CoreApp\Traits;

use App\Models\Notification;
use App\Models\Notification\NotificationType;
use App\Models\UserDevice\UserDevice;
use App\Repositories\Settings\ApiSetupRepository;
use Ramsey\Uuid\Uuid;

trait FirebaseNotification
{
    protected $apiSetupRepo;

    public function __construct(ApiSetupRepository $apiSetupRepo)
    {
        $this->apiSetupRepo = $apiSetupRepo;
    }
    public function sendFirebaseNotification($user_id, $notification_type, $id = null, $url)
    {
        try {
            //if env app is not production then return
            if (env('APP_ENV') == 'production') {
                $notification = NotificationType::where('type', $notification_type)->firstOrFail();
                $firebaseToken = UserDevice::where('user_id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();

                $firebase_key = getSetting('firebase');
                $settings = settings('firebase');
                $SERVER_API_KEY = env('FIREBASE_API_KEY');
                if (isset($firebase_key) && $firebase_key->key != null) {
                    $SERVER_API_KEY = $firebase_key->key;
                } elseif ($settings) {
                    $SERVER_API_KEY = $settings;
                }

                $data = [
                    "registration_ids" => $firebaseToken,
                    "data" => [
                        "title" => $notification->title,
                        "body" => $notification->description,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification->type,
                        "image" => $notification->icon ? uploaded_asset($notification->icon) : null,
                    ],
                    "aps" => [
                        "title" => $notification->title,
                        "body" => $notification->description,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification->type,
                        "sound" => "default",
                        "image" => $notification->icon ? uploaded_asset($notification->icon) : null,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);
                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                $response = curl_exec($ch);
                return $response;
            } else {
                return true;
            }

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function sendCustomFirebaseNotification($user_id, $notification_type, $url, $title, $body, $image = null,$id = null)
    {
        try {
            //if env app is not production then return
            if (env('APP_ENV') == 'production') {
                $firebaseToken = UserDevice::where('user_id', $user_id)->whereNotNull('device_token')->pluck('device_token')->all();

                $firebase_key = getSetting('firebase');
                $settings = settings('firebase');
                $SERVER_API_KEY = env('FIREBASE_API_KEY');
                if (isset($firebase_key) && $firebase_key->key != null) {
                    $SERVER_API_KEY = $firebase_key->key;
                } elseif ($settings) {
                    $SERVER_API_KEY = $settings;
                }

                $data = [
                    "registration_ids" => $firebaseToken,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "image" => $image,
                    ],
                    "aps" => [
                        "title" => $title,
                        "body" => $body,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "sound" => "default",
                        "image" => $image,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                return $response;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function sendChannelFirebaseNotification($channel, $notification_type, $id = null, $url, $title, $body, $image = null)
    {
        try {
            //if env app is not production then return
            if (env('APP_ENV') == 'production') {

                $firebase_key = getSetting('firebase');
                $settings = settings('firebase');
                $SERVER_API_KEY = env('FIREBASE_API_KEY');
                if (isset($firebase_key) && $firebase_key->key != null) {
                    $SERVER_API_KEY = $firebase_key->key;
                } elseif ($settings) {
                    $SERVER_API_KEY = $settings;
                }

                $data = [
                    "to" => '/topics/' . $channel,
                    // "to" => '/topics/onesthrm',
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "image" => $image,
                    ],
                    "aps" => [
                        "title" => $title,
                        "body" => $body,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "sound" => "default",
                        "image" => $image,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                return $response;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function sendCustomNotification($user, $details, $reason)
    {
        try {
            $notification = new Notification();
            $notification->id = Uuid::uuid4();
            $notification->type = 'App\Notifications\HrmSystemNotification';
            $notification->notifiable_type = 'App\Models\User';
            $notification->notifiable_id = is_object($user) ? $user->id : $user;
            $notification->data = json_encode($details);
            $notification->notification_for = $reason['notification_for'];
            $notification->id_for = $reason['notification_id'];
            $notification->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }

    }
}
