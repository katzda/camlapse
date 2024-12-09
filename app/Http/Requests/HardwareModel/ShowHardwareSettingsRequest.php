<?php

namespace App\Http\Requests\HardwareModel;

use Illuminate\Foundation\Http\FormRequest;

class ShowHardwareSettingsRequest extends FormRequest
{
    public $hardware_id;
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
            'hardware_id' => 'required|exists:camlapses,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->hardware_id = $this->route('hardware');

        $this->merge([
            'hardware_id' => $this->hardware_id
        ]);
    }

}
