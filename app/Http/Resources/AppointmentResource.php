<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
               "Appointment Discreption" => $this->discreption,
               "Appointment Date" => $this->appointment_date,
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
