<?php

namespace App\Http\Requests;

use App\Rules\ValidCpfRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'name'      => 'required|string|max:255|min:3',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'birthdate' => 'required|date_format:d-m-Y|before:'. Carbon::now()->subYears(21)->toDateString(),
            'password'  => 'required|string|min:8|confirmed',
            'CPF'       => ['required','string', 'numeric', 'unique:users,CPF', new ValidCpfRule()],
        ];
    }

    public function messages()
    {
        return[
            'birthdate.before' => 'It should have at least 21 years old.',
        ];
    }
}
