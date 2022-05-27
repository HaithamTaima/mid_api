<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{

    public function toArray($request)
    {
        return [
//            'id' => $this->id,
//            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'content' => $this->content,
            'created_at' => (string) $this->created_at,

        ];
    }
}
