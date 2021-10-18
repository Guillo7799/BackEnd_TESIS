<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class Publication extends JsonResource
{
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
            'business_name'=>$this->business_name,
            'career' => $this->career,
            'description' => $this->description,
            'hours' => $this->hours,
            'date' => $this->date,
            'city'=>$this->city,
            'contact_email'=>$this->contact_email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => '/api/users/' . $this->user_id,
            'category' =>  $this->category_id,
        ];
    }
}