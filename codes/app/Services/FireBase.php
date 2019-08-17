<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

/**
 * FireBase Push Message Class
 */
class FireBase
{
    /**
     * Api Access Token
     *
     * @var string
     */
    protected $apiAccessKey;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->apiAccessKey = config('services.firebase.api-access-key');
    }

    /**
     * Get HTTP Client
     *
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        return new GuzzleClient([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'key=' . $this->apiAccessKey,
            ],
            'verify' => config('services.firebase.ssl-verify'),
            'connect_timeout' => 10.0,
            'timeout'  => 10.0,
        ]);
    }

    /**
     * Call FireBase API
     *
     * @param  string|array $receivers String for pushing to topic, Array for pushing to devices by id
     * @param  array $payload
     * @return boolean
     */
    public function call($receivers, $payload)
    {
        $data = array_merge([
            'vibrate' => 1,
            'sound' => 1,
        ], $payload);

        $success = $data['status'] ?? true;
        $message = $data['msg'] ?? 'Ok';
        $type = $data['type'] ?? '_blank_';

        if (isset($data['status'])) {
            unset($data['status']);
        }

        if (isset($data['msg'])) {
            unset($data['msg']);
        }

        $data = [
            'data' => [
                'success' => $success,
                'code' => 200,
                'type' => $type,
                'message' => $message,
                'data' => $data,
            ],
            'priority' => 'high',
            'ttl' => 10,
        ];

        if (is_string($receivers)) {
            $data['to'] = $receivers;
        }
        elseif (is_array($receivers)) {
            $data['registration_ids'] = $receivers;
        }

        $res = $this->client()->request('POST', 'https://fcm.googleapis.com/fcm/send', [
            'json' => $data,
        ]);

        $body = json_decode($res->getBody(), true);

        Log::info('FireBase Push Sent! Request:'.json_encode($data).'! Response:'.$res->getBody());

        if ($res->getStatusCode() >= 200 && $res->getStatusCode() < 300) {
            return isset($body["failure"]) && $body["failure"] > 0 ? false : true;
        } else {
            return false;
        }
    }
}
