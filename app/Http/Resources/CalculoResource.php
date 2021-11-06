<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalculoResource extends JsonResource
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
            'uf'            => $this->uf,
            'valor_pedido'  => $this->valor_pedido,
            'valor_cotacao' => $this->valor_cotacao,
            'transportadora'    => new TransportadoraResource($this->transportadora),
        ];
    }
}
