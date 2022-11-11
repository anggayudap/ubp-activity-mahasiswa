<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KegiatanResource extends JsonResource
{
    public $status_code;
    public $messages;

    public function __construct($status_code, $messages, $resource)
    {
        parent::__construct($resource);
        $this->status_code = $status_code;
        $this->messages = $messages;
    }

    public function toArray($request)
    {
        return [
            'status_code' => $this->status_code,
            'message' => $this->messages,
            'data' => $this->resource,
        ];
    }
}
