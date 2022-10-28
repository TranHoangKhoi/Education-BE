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
            'idUser' => $this->id_user,
            'name' => $this->name,
            'email' => $this->user->email,
            'nameId' => $this->name_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'role_ad' => $this->role,
            // 'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            // 'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
