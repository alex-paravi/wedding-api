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
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'side' => $this->side,
            'category' => $this->category,
            'status' => $this->status,

            // ID стола отдаем всегда (он может быть null, если гость не рассажен)
            'table_id' => $this->table_id,

            // Информацию о самом столе отдаем ТОЛЬКО если ее запросили через with('table')
            'table' => $this->whenLoaded('table', function () {
                return $this->table ? [
                    'id' => $this->table->id,
                    'name' => $this->table->name, // Изменено с 'number' на 'name'
                    'capacity' => $this->table->capacity,
                ] : null;
            }),

            'user_id' => $this->user_id,

            // Данные создателя отдаем только при eager loading через with('user')
            'created_by' => $this->whenLoaded('user', function () {
                return $this->user ? [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ] : null;
            }),

            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
