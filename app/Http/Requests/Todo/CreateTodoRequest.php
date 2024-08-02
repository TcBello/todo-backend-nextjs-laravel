<?php

namespace App\Http\Requests\Todo;

use App\Http\Requests\BaseRequest;

class CreateTodoRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|numeric",
            "content" => "required|string"
        ];
    }
}
