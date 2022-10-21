<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->user->id,
            'nameID' => $this->name_id,
            'name' => $this->name,
            'email' => $this->user->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
        ];
    }
}
