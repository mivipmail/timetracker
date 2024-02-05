<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->locale('ru')->translatedFormat('d F, H:i'),
            'started_at' => $this->started_at ? Carbon::parse($this->started_at)->locale('ru')->translatedFormat('d F, H:i') : null,
            'time' => Carbon::createFromTimestamp($this->time)->format('H:i:s'),
        ];
    }
}
