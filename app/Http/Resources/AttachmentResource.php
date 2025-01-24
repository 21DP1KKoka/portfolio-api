<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->images;
        if ($images) {
            $images = $images->where('attachment_id', $this->id);
        }
        return [
            'images' => ImageResource::collection($images),
        ];
    }
}
