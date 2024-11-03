<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CamLapseCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255','unique:camlapses'],
            'purpose' => ['string'],
            'between_time_start' => ['date_format:H:i'],
            'between_time_end' => ['date_format:H:i'],
            'stop_datetime' => ['nullable', 'date'],
            'cron_min' => ['required', 'string'],
            'cron_hour' => ['required', 'string'],
            'cron_day' => ['required', 'string'],
            'cron_weekday' => ['required', 'string'],
            'cron_month' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'purpose' => $this->purpose ?? '',
            'between_time_start' => $this->between_time_start ?? '00:00',
            'between_time_end' => $this->between_time_end ?? '23:59'
        ]);
    }
}
