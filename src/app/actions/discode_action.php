<?php

class DiscodeAction
{
    private $webhookUrl;

    public function __construct()
    {
        $discodeId        = getenv('DISCODE_ID');
        $discodeToken     = getenv('DISCODE_TOKEN');
        $this->webhookUrl = 'https://discord.com/api/webhooks/' . $discodeId . '/' . $discodeToken;
    }

    public function sendMessage($message)
    {
        $data = [
            'content' => $message
        ];

        $context = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => json_encode($data),
                'ignore_errors' => true
            ]
        ]);

        return file_get_contents($this->webhookUrl, false, $context);
    }
}