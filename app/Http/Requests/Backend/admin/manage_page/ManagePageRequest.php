<?php

namespace App\Http\Requests\Backend\admin\manage_page;

use App\Http\Requests\Request;

class ManagePageRequest extends Request
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
            'desktop_content'              => 'required',
            'responsive_content'              => 'required'
        ];
    }
}
