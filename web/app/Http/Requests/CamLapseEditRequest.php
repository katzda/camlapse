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
            'description' => ['nullable','string'],
            'fph' => ['required','integer','min:1'],
            'between_hour_start' => ['nullable', 'integer','min:0', 'max:24'],
            'between_hour_end' => ['nullable', 'integer', 'min:0', 'max:24'],
            'memory_period' => ['nullable', 'integer', 'min:1', 'max:4'],
            'stop_datetime' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->camlapse = $this->route('camlapse');

        $this->merge([
            'id' => $this->camlapse->id
        ]);
    }
}
