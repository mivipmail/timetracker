<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectBriefResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => Carbon::parse($this->created_at)->locale('ru')->translatedFormat('d F, H:i'),
            'active_tasks_count' => $this->active_tasks_count,
            'tasks_count' => $this->tasks_count,
            'tasks_sum_time' => Carbon::createFromTimestamp($this->tasks_sum_time ?? 0)->format('H:i:s'),
        ];
    }
}
