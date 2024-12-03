<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                'regex:/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', 'image', 'max:1024'], // максимум 1MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.regex' => 'Email может содержать только латинские буквы, цифры и символы . _ -',
            'email.email' => 'Введите корректный email адрес',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.max' => 'Размер изображения не должен превышать 1MB',
        ];
    }
}
