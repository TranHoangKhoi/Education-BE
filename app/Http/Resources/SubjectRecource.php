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
            'id' => $this->id,
            'id' => $this->id,
            'idSemester' => $this->id_semester,
            'nameSemester'=>$this->semester->name_id,
            'idClass' => $this->id_class,
            'nameClass'=>$this->classData->name_class,
            'idMajor' => $this->id_major,
             'nameMajor'=>$this->majors->name_major,
            'idType' => $this->type,
            'subjectType'=>$this->subjectType->type_name,
            'nameId' => $this->name_id_subject,
            'name' => $this->name ,
            'credit' => $this->credit,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
