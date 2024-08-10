<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    protected $lang;

    public function __construct($resource, $lang = 'en')
    {
        parent::__construct($resource);
        $this->lang = $lang;
    }

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
            'title' => $this->getTranslation('title', $this->lang),
            'sub_desc' => $this->getTranslation('sub_desc', $this->lang),
            'desc' => $this->getTranslation('desc', $this->lang),
            // 'city' => new CityResource($this->whenLoaded('city')),
            // 'tour_type' => new TourTypeResource($this->whenLoaded('tourType')),
            // 'attachments' => AttachmentResource::collection($this->whenLoaded('AttachFile')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration' => $this->duration,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
