<?php

namespace App\Http\Requests\Order;

use App\Helpers\ResponseFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateOrderRequest extends FormRequest
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
            // sender
            "sender_name" => ["required", "string"],
            "sender_address" => ["required"],
            "sender_postal_code" => ["required", "numeric"],
            "sender_phone" => ["required", "numeric"],
            // recipient
            "recipient_name" => ["required", "string"],
            "recipient_address" => ["required"],
            "recipient_postal_code" => ["required", "numeric"],
            "recipient_phone" => ["required", "numeric"],
            // items
            "name" => ["required"],
            "description" => ["required"],
            "qty" => ["required", "numeric"],
            "weight" => ["required", "numeric"],
            "price" => ["required", "numeric"]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            ResponseFormatter::validationError([
                    'message' => 'Validation errors',
                    'errors' => $errors
            ])
        );
    }
}
