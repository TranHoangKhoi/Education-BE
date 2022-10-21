<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Students;

class StudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'id_course' => $this->id_course,
            'name_course' => $this->course->name_id,
            'id_class' => $this->id_class,
            'name_class' => $this->class->name_id,
            'id_major' => $this->id_major,
            'name_major' => $this->majors->name_major,
            'name_id_major' => $this->majors->name_id,
            'name' => $this->name,
            'name_id' => $this->name_id,
            'email ' => $this->user->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
        ];
    }
}
