<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'home_team' => 'required|string',
            'away_team' => 'required|string',
        ];
    }
}
