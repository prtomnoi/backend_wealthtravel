<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->getTranslation('name', $this->lang),
            'image' => $this->image ? url('app/product/' . $this->image) : null,
            'price' => $this->price,
            'price_sale' => $this->price_sale,
            'star' => $this->star,
            'status' => $this->status,
            'product_type' => new ProductTypeResource($this->whenLoaded('productType')),
        ];
    }
}
