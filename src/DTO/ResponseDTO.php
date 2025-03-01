<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;

class ResponseDTO
{
    #[Groups(['response'])]
    public bool $success;
    #[Groups(['response'])]
    public string $message;
    #[Groups(['response'])]
    public string $code;
    #[Groups(['response'])]
    public ?array $data;

    public function __construct(bool $success, string $message, string $code, ?array $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function getResponse(): array
    {
        $response = [
            'success' => $this->success,
            'message' => $this->message
        ];

        if (!is_null($this->data)) {
            $response['data'] = $this->data;
        }

        return $response;
    }
}