<?php

namespace App\Http\Requests\Test;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormTestCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Category::find($this->category_id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:4|max:255',
            'short_description' => 'required|string|min:5|max:300',
            'description' => 'required|string|min:5|max:10000',
            'is_active' => 'boolean',
            'cover' => 'image|max:2000',
            'category_id' => 'required|numeric'
        ];
    }
}
