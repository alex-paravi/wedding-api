<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'name' => $this->name,       // Наша колонка name из SQLite
            'capacity' => $this->capacity,
            'user_id' => $this->user_id,

            // Показываем список гостей за этим столом, ТОЛЬКО если была загружена связь with('guests')
            // Используем GuestResource::collection(), так как гостей за столом МНОГО (HasMany)
            'guests' => GuestResource::collection($this->whenLoaded('guests')),

            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
