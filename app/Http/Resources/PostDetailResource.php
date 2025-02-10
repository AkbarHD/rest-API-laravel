<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'author' => $this->User->username,
            'lastname' => $this->User->lastname, // kita bs ambil isi column table users, tergantung dari with([])
            'firstname' => $this->User->firstname,
            'password' => $this->User->password,
            'writer' => $this->User, // kalo sperti ini bakalan muncul semua agar bs muncul bbrp aja setting di with
        ];
    }
}
