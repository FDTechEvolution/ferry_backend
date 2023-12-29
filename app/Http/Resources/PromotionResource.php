<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'code' => $this->code,
            'description'=>$this->description,
            'image'=>isset($request->image->path)?$request->image->path:'',
            'created_at'=>Carbon::parse($request->created_at)->format('d M Y h:i')
        ];
    }
}
