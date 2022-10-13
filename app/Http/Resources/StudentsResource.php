<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Students;

class StudentsResource extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,
            'idCourse' => $this->id_course,
            'idClass ' => $this->id_class ,
            'idMajor' => $this->id_major,
            'nameId' => $this->name_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
        ];
    }
}
