<?php

namespace App\Http\Requests;

class CamLapseEditRequest extends CamLapseCreateRequest
{
    public $camlapse;

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'id' => ['required','integer','exists:camlapses,id'],
            'name' => ['required','string','max:255','unique:camlapses,id,'.$this->camlapse->id],
        ]);
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
