<?php

namespace App\Http\Requests\Endpoints\Tournament;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPlayerPackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $playerPack = $this->route('playerPack');

        return $playerPack && $this->user()->hasAccessToTournament($playerPack->tournament_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
