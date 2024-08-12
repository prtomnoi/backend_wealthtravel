<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TourCollection extends ResourceCollection
{
    protected $lang;

    public function __construct($resource, $lang = 'en')
    {
        parent::__construct($resource);
        $this->lang = $lang;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $queryParams = $request->query();

        return [
            'data' => $this->collection->map(function ($tour) {
                return (new TourResource($tour, $this->lang))->toArray(request());
            })->all(),
            'links' => [
                'first' => $this->getFinalUrl($this->url(1), $queryParams),
                'last' => $this->getFinalUrl($this->url($this->lastPage()), $queryParams),
                'prev' => $this->getFinalUrl($this->previousPageUrl(), $queryParams),
                'next' => $this->getFinalUrl($this->nextPageUrl(), $queryParams),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
                'path' => $this->path(),
                'links' => $this->linkCollection(),
            ],
        ];
    }

    /**
     * Generate the final URL with query parameters, ensuring only one URL is returned.
     *
     * @param  string|null  $url
     * @param  array  $queryParams
     * @return string|null
     */
    protected function getFinalUrl($url, $queryParams)
    {
        if (!$url) {
            return null;
        }

        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'] ?? '', $existingParams);
        $finalParams = array_merge($existingParams, $queryParams);

        return url($parsedUrl['path'] . '?' . http_build_query($finalParams));
    }

    /**
     * Generate a collection of links for the pagination.
     *
     * @return array
     */
    protected function linkCollection()
    {
        return [
            [
                'url' => $this->url(1),
                'label' => '&laquo; Previous',
                'active' => false,
            ],
            [
                'url' => $this->url($this->lastPage()),
                'label' => 'Next &raquo;',
                'active' => false,
            ],
        ];
    }
}
