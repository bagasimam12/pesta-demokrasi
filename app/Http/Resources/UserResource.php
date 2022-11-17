<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Kelas;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'email'  => $this->email,
            'nis'    => $this->nis,
            'kelas'  => new KelasResource(
                Kelas::find($this->kelas_id)
            )
        ];
    }
}
