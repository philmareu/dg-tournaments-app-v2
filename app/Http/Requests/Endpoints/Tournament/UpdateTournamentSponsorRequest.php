<?php

namespace App\Http\Requests\Endpoints\Tournament;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentSponsorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $tournamentSponsor = $this->route('tournamentSponsor');

        return $tournamentSponsor && $this->user()->hasAccessToTournament($tournamentSponsor->tournament_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sponsor_id' => 'exists:sponsors,id'
        ];
    }
}
