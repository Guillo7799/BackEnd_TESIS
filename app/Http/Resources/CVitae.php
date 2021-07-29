<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CVitae extends JsonResource
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
            'user' => '/api/users/' . $this->user_id,
            'university' => $this->university,
            'career' => $this->career,            
            'language' => $this->language,
            'level_language' => $this->level_language,
            'habilities' => $this->habilities,
            'certificates' => $this->certificates,
            'highschool_degree' => $this->highschool_degree,
            'work_experience' => $this->work_experience,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}