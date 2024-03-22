<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SharedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        self::$wrap = null;

        return [
            'file_id' => $this->file_id,
            'name' => $this->name,
            'code' => 200,
            'url' => url("files/$this->file_id"),
            'accesses' => AccessResource::collection($this->access)
        ];
    }
}
