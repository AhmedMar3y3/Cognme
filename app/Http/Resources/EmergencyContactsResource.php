<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyContactsResource extends JsonResource
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
               "Emergency Contact Name" => $this->name,
               'Emergency person image' => $this->image ? asset('storage/' . $this->image) : null,
               "Emergency Contact" => $this->contact,
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
