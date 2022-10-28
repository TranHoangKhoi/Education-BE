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
            'idCourse' => $this->id_course,
            'nameCourse' => $this->course->name_id,
            'idClass' => $this->id_class,
            'nameClass' => $this->class->name_class,
            'idMajor' => $this->id_major,
            'nameMajor' => $this->majors->name_major,
            'nameIdMajor' => $this->majors->name_id,
            'name' => $this->name,
            'mssv' => $this->mssv,
            'email ' => $this->user->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
