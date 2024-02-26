<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysicianResource extends JsonResource
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
               "Physician Name" => $this->name,
               "Physician Email" => (string)$this->email,
               "Physician Address" => $this->address,
               "Specialization" => $this->specialization,
               "Physician Contact" => $this->contact,
               "created_at" => $this->created_at,
               "updated_at" => $this->updated_at
            ],
            'relationships' => [
                'user' => $this->user
                    ? [
                        'id' => (string) $this->user->id,
                        'user name' => $this->user->name,
                        'user email' => (string) $this->user->email,
                    ]
                    : null,
            ],
            
        ];
    }
}
/*  return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'specialization' =>$this->specialization,
            'contact' => $this->contact,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];*/
             /* 'id' =>(string)$this->physician_id,
                'physician name' =>$this->name,
                'physician email' =>$this->email,*/