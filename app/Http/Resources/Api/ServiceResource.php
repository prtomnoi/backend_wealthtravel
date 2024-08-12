<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'date' => $this->date,
            'status' => $this->status,
            'service_type' => new ServiceTypeResource($this->whenLoaded('serviceType')),
        ];
    }
}
