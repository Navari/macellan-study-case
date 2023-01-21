<?php

namespace Modules\Location\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallbackServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|exists:users,id',
            'ref_code' => 'required|string|exists:toll_gates,id',
            'price' => 'required|numeric',
            'point' => 'required|numeric',
            'callback_success_url' => 'required|string|url',
            'callback_fail_url' => 'required|string|url',
            'order_id' => 'required|string',
            'hash' => ['required', 'string'],
        ];
    }
}
