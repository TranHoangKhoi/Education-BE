<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            // 'id' => $this->id,
            'id_acc' => $this->id_user,
            'name' => $this->name,
            'email' => $this->user->email,
            'name_id' => $this->name_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'role_ad' => $this->role,
        ];
    }
}
