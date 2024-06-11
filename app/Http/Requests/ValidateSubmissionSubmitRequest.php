<?php

namespace App\Http\Requests;

use App\DTO\SubmissionDTO;
use Illuminate\Foundation\Http\FormRequest;

class ValidateSubmissionSubmitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required',
        ];
    }

    public function toDTO(): SubmissionDTO
    {
        return new SubmissionDTO(
            name: $this->name,
            email: $this->email,
            message: $this->message
        );
    }
}
