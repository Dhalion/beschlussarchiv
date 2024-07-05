<?php

namespace App\Http\Requests\V3;

use App\Enums\ResolutionStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreResolutionRequest extends FormRequest
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
            'title' => 'required|string',
            'tag' => 'required|string',
            'year' => 'required|integer',
            'text' => 'required|string',
            'status' => Rule::enum(ResolutionStatus::class),
            'categoryId' => 'required|exists:categories,id',
            'councilId' => 'required|exists:councils,id',
            'applicantsIds' => 'required|array|min:1',
            'applicantsIds.*' => 'required|exists:applicants,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->categoryId,
            'council_id' => $this->councilId,
        ]);
    }
}
