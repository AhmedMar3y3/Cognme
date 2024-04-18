<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photoUrls = $this->photo_paths ? json_decode($this->photo_paths) : [];
        $photoUrls = array_map(function ($path) {
            return Storage::disk('public')->url($path);
        }, $photoUrls);

        return [
            "id" => (string) $this->id,
            "attributes" => [
                "Patient Name" => $this->name,
                "Medical History" => $this->medical_history,
                "Photos" => $photoUrls,
                "Patient Address" => $this->address,
                "created_at" => $this->created_at->toDateTimeString(),
                "updated_at" => $this->updated_at->toDateTimeString(),
            ],
            'relationships' => [
                'user' => $this->whenLoaded('user', function () {
                    return [
                        'id' => (string) $this->user->id,
                        'user name' => $this->user->name,
                    ];
                }),
            ],
        ];
    
    }
}
