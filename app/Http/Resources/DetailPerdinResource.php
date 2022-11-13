<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPerdinResource extends JsonResource
{
    public $message;
    public $status;
    function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->status = $status;
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            'detail_tarif'      => $this->resource
        ];
        
    }
}
