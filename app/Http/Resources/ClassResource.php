<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
            'id' => $this->id,
            'idCourse'=>$this->id_course,
            'nameCourse'=>$this->course->name_id,
            'idMajors'=>$this->id_major,
            'nameIdMajor'=>$this->majors->name_id,
            'nameMajor'=>$this->majors->name_major,
            'nameClass'=>$this->name_class,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
