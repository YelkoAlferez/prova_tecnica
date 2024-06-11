<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::check()){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tariffs' => 'required|array|min:1',
            'tariffs.*.start_date' => 'required|date',
            'tariffs.*.end_date' => 'required|date|after:tariffs.*.start_date',
            'tariffs.*.price' => 'required|numeric',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
