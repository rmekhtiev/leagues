<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'league_id' => ['nullable', 'exists:leagues,id'],
            'home_team_id' => ['nullable', 'exists:teams,id'],
            'away_team_id' => ['nullable', 'exists:teams,id'],
            'home_team_score' => ['nullable'],
            'away_team_score' => ['nullable'],
            'week' => ['nullable'],
            'started_at' => ['nullable'],
            'finished_at' => ['nullable'],
        ];
    }
}
