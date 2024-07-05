<?php

namespace App\Http\Requests\V3;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicantRequest extends FormRequest
{
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
            'name' => [
                'required',
                'string',
                Rule::unique('applicants', 'name')->where(function ($query) {
                    return $query->where('council_id', $this->council_id);
                })
            ],
            'councilId' => 'required|exists:councils,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'council_id' => $this->councilId,
        ]);
    }
}
