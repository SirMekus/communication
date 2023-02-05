<?php

namespace App\Interfaces;

interface MessageRepositoryInterface 
{
    public function send(array $data);

    public function getMe();

    public function getUpdate();

    public function inviteToChannel(array $data);

    public function getWebhookInfo();
}