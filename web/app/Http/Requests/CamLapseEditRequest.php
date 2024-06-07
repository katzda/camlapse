<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CamLapseEditRequest extends FormRequest
{
    public $camlapse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required','integer','exists:camlapses,id'],
            'name' => ['required','string','max:255','unique:camlapses,id,'.$this->camlapse->id],
            'purpose' => ['string'],
            'fph' => ['required','integer','min:1'],
            'between_time_start' => ['date_format:H:i'],
            'between_time_end' => ['date_format:H:i'],
            'cron_day' => ['required', 'string'],
            'cron_weekday' => ['required', 'string'],
            'cron_month' => ['required', 'string'],
            'cron_year' => ['required', 'string'],
            'stop_datetime' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->camlapse = $this->route('camlapse');

        $this->merge([
            'id' => $this->camlapse->id,
            'purpose' => $this->purpose ?? '',
            'between_time_start' => $this->between_time_start ?? '00:00',
            'between_time_end' => $this->between_time_end ?? '23:59'
        ]);
    }
}
