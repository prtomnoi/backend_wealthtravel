<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_url' => $this->getFileUrl(), // Construct the full file URL
            'type' => $this->type,
        ];
    }

    /**
     * Get the full URL for the attachment.
     *
     * @return string|null
     */
    protected function getFileUrl()
    {
        if (!$this->path) {
            return null; // Handle case where path might be null
        }

        // Assuming the path is stored relative to the storage/public directory
        return url('app/' . $this->path);
    }
}
