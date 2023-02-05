<?php

namespace App\Repositories;

use App\Interfaces\MessageRepositoryInterface;

use Telegram\Bot\Api;

use Telegram\Bot\Exceptions\TelegramResponseException;

class TelegramRepository implements MessageRepositoryInterface
{
	protected $telegram;

	public $error;

	public function __construct()
	{
		$token = config("telegram.bots.mybot.token");

		$this->telegram = new Api($token);
		
		// $this->telegram->setWebhook([
		// 	'url' => route('webhook', ['token'=>$token])
		// ]);
	}
	
	public function send(array $data)
	{
		try
		{
			$this->telegram->sendMessage($data);
		}
		catch(TelegramResponseException)
		{
			return response("Chat not found. Please try again with a valid chat id", 422);
		}
	}

	public function getMe()
	{
		$response = $this->telegram->getMe();

        // $botId = $response->getId();
		// $firstName = $response->getFirstName();
		// $username = $response->getUsername();

		return $response;
	}

	public function getUpdate()
	{
		return $this->telegram->getUpdates();
	}

	public function inviteToChannel(array $param)
	{
		try
		{
			$response = $this->telegram->createChatInviteLink($param);

			return $response;
		}
		catch(TelegramResponseException $e)
		{
			switch($e->getResponseData()['description'])
            {
                case "Bad Request: USER_ALREADY_PARTICIPANT":
					abort(422, "This user is already a participant");

                    break;

				case "Bad Request: USER_ID_INVALID":
					abort(422, "This user id is invalid");

					break;

                default:
				    $this->error = $e->getResponseData()['description'];
            }

			return false;
		}
	}

	public function getWebhookInfo()
	{
		return $this->telegram->getWebhookUpdate();
	}
}
?>
		