<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriaVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|string|min:1|max:60',
            'descricao' => 'present|string|max:1000',
            'url' => 'required|url',
            'categoria_id' => 'integer',
        ];
    }

    public function validated()
    {
        return $this->only(['titulo', 'descricao', 'url', 'categoria_id']);
    }
}
