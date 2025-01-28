<?php

namespace App\Http\Resources\News;

use App\Enums\NewsServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'service' => $this->service ? NewsServices::from($this->service)->name : null,
            'section' => $this->section,
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'author' => $this->author,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at,
            'source' => [
                'id' => $this->external_id,
                'name' => $this->getMetadataValue('source_name'), // Example for extracting from metadata
            ],
            'metadata' => $this->metadata,
            'created_at'=> Carbon::parse($this->created_at)->toDateTimeString(),
        ];

    }
    /**
     * Extract specific values from the metadata JSON column.
     *
     * @param  string  $key
     * @return mixed
     */
    private function getMetadataValue(string $key): mixed
    {
        if (!$this->metadata)
            return null;

        $metadata = json_decode($this->metadata, true);

        return $metadata[$key] ?? null;
    }
}
