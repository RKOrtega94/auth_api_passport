<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Twilio\Rest\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Success response method.
     *
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    function sendResponse($result, $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'result' => $result,
            'message' => $message
        ], 200);
    }

    /**
     * Return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Send SMS to user
     *
     * @param string $phone
     * @param string $message
     *
     * @return bool
     */
    function sendSMS($phone, $message): bool
    {
        try {
            $accountSid = env('TWILIO_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $twilioNumber = env('TWILIO_NUMBER');

            $client = new Client($accountSid, $authToken);

            $client->messages->create(
                $phone,
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );

            return true;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }
}
