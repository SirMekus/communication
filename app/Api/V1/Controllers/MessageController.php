<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;

use App\Interfaces\MessageRepositoryInterface;

class MessageController extends Controller
{

    public function __construct(private MessageRepositoryInterface $telegram)
	{
		
	}

    /**
     * @OA\Get(
     *     path="/api/get-me",
     *     description="Gets profile of user BOT",
     *     @OA\Parameter(
     *         name="user-id",
     *         in="header",
     *         description="one of the pre-defined User IDs",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful; returns an object containing a User's BOT info"
     *     )
     * )
     */
    public function getMe()
    {
        return $this->telegram->getMe();
    }

    /**
     * @OA\Post(
     *     path="/api/invite-to-channel",
     *     description="Subscribes user to a channel or chat by creating and returning a link through 
     *                  which user can join the channel",
     *     @OA\Parameter(
     *         name="user-id",
     *         in="header",
     *         description="one of the pre-defined User IDs",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input or incomplete form entry"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful; returns an object containing a link which should be sent to a 
     *                      user to join the group"
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="chat_id",
     *                     description="id representing a chat or channel",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function inviteToChannel()
    {
        request()->validate([
            'chat_id' => ['bail', 'nullable', 'string'],
        ]);

        $response = $this->telegram->inviteToChannel([
            'chat_id' => request()->chat_id ?? config('telegram.bots.mybot.chat_id')
          ]);

        return response($response);
    }

    /**
     * @OA\Get(
     *     path="/api/get-update",
     *     description="An alternative to Webhook since Telegram webhook requires HTTPS which is not 
     *                  available on a local development environment",
     *     @OA\Parameter(
     *         name="user-id",
     *         in="header",
     *         description="one of the pre-defined User IDs",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful; returns an object containing information on channel where the BOT 
     *                      is present and an Admin"
     *     )
     * )
     */
    public function getUpdate()
    {
        return $this->telegram->getUpdate();
    }

     /**
     * @OA\Post(
     *     path="/api/send-message",
     *     description="Send a message to subscribers in a channel",
     *     @OA\Parameter(
     *         name="user-id",
     *         in="header",
     *         description="one of the pre-defined User IDs",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input or incomplete form entry"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="chat_id",
     *                     description="id representing a chat or channel",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     description="The message to be sent to subscribers in a channel",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function sendMessage()
    {
        request()->validate([
            'chat_id' => ['bail', 'nullable', 'string'],
            'message' => ['bail', 'required', 'string'],
        ]);

        $this->telegram->send([
            'chat_id' => request()->chat_id ?? config('telegram.bots.mybot.chat_id'),
            'text' => request()->message,
          ]);

        return response('Message was sent successfully');
    }

    public function getWebhookMessage()
    {
        return $this->telegram->getWebhookInfo();
    }
}