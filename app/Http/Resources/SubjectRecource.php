<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectRecource extends JsonResource
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
            'idSemester' => $this->id_semester,
            'id' => $this->id,
            'idClass' => $this->id_class,
            'idMajor' => $this->id_major,
            'subjectType' => $this->subject_type, 
            'nameId' => $this->name_id, 
            'name' => $this->name, 
            'credit' => $this->credit, 
        ];
    }
}
