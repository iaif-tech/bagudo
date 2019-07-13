<?php

namespace Modules\Death\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeathFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
           'first_name' => 'required|integer',
           'last_name' => 'required|string',
           'place' => 'required|string',
           'date' => 'required',
           'about_death' => 'required|string',
           'death_at' => 'required|string'
        ];

        if($this->has('update')){
          $rules['date'] = '';
          $rules['first_name'] = 'required|string';
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
