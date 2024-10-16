<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'validated_at' => $this->validated_at,
            'user_validated' => UserResource::make($this->user_validated),
            'author' => UserResource::make($this->whenLoaded('user')),
            'lignes' => FieldLigneResource::collection($this->whenLoaded('lignes')),
            'status' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
