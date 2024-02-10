<?php

namespace SlothDevGuy\Files\Http\Requests\Files;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'disk' => ['required', 'string', 'max:255'],
            'path' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'metadata' => ['sometimes', 'required', 'array'],
        ];
    }
}
