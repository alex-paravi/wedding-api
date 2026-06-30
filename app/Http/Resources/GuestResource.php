<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'side' => $this->side,
            'category' => $this->category,
            'status' => $this->status,
            'table_number' => $this->table_number,
            'created_by' => $this->user_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
