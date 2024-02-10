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
            'references.*.uuid' => ['sometimes', 'required', 'string', 'size:36'],
            'references.*.service' => ['sometimes', 'required', 'string', 'max:255'],
            'references.*.entity_type' => ['sometimes', 'required', 'string', 'max:255'],
            'references.*.entity_id' => ['sometimes', 'required', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function fileValues(): array
    {
        return $this->validated(['disk', 'path', 'name', 'metadata']);
    }

    /**
     * @return array
     */
    public function references(): array
    {
        return $this->validated('references', []);
    }
}
