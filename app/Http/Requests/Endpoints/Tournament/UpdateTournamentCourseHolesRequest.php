<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentCourseHolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $tournamentCourse = $this->route('tournamentCourse');

        return $tournamentCourse && $this->user()->hasAccessToTournament($tournamentCourse->tournament_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'holes' => 'required|'
        ];
    }
}
