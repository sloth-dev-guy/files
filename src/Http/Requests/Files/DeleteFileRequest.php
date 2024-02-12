<?php

namespace SlothDevGuy\Files\Http\Requests\Files;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'remove_at' => ['sometimes', 'required', 'date'],
        ];
    }
}
