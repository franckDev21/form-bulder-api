<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'type' => $this->type,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'crypted' => $this->crypted,
            'key' => $this->key,
            'options' => $this->options,
        ];
    }
}
