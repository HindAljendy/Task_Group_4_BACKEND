<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->id,
            'client_name'                 => $this->client_name,
            'client_email'                => $this->client_email,
            'message_subject'             => $this->message_subject,
            'message_description'         => $this->message_description,

        ];
    }
}
