<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPerdinResource extends JsonResource
{
    function __construct($resource)
    {
        parent::__construct($resource);
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resource;
        //return parent::toArray($request);
        
    }
}
