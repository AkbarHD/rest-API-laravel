<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostrResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $square = 4;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'author' => $this->User->username,
            'writer' => $this->whenLoaded('User'), // sbnrnya sama aja
            // comment
            'komentar' => $this->whenLoaded('Comments', function(){
                return collect($this->Comments)->each(function($comment){
                    $comment->Comentator;
                    return $comment;
                });
            }),
            // 'total_comment' => $this->Comments->count(), // bisa juga seperti ini
            'total_comment' => $this->whenLoaded('Comments', function(){
                return $this->Comments->count();
            }),
        ];
    }
}
