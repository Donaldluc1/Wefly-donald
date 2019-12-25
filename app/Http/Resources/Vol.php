<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vol extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return[
            'id' => $this->id,
            'dateDepart' => $this->dateDepart,
            'heureDepart' => $this->heureDepart,
            'dateArrivee' => $this->dateArrivee,
            'heureArrivee' => $this->heureArrivee
        ];
    }
}
