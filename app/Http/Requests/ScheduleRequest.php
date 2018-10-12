<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:150',
            'phone_number' => 'required|string|max:50',
            'city_id' => 'required|exists:cities,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:m',
            'duration' => 'required|integer|between:0,24',
        ];
    }
}
