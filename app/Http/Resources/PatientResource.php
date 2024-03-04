<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>(string)$this->id,
            "attributes" => 
            [
               "Patient Name" => $this->name,
               "Patient Age" => $this->age,
               "Patient disease" => $this->disease,
               "Discreption" => $this->discreption,
               "Patient Address" => $this->address,
               "created_at" => $this->created_at,
               "updated_at" => $this->updated_at
            ],
            'relationships' => [
                'user' => $this->user
                    ? [
                        'id' => (string) $this->user->id,
                        'user name' => $this->user->name,
                    ]
                    : null,
            ],
            
        ];
    }
}
