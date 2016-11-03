<?php

namespace App\Http\Requests\Backend\admin\promotion;

use App\Http\Requests\Request;

class PromotionRequest extends Request
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
        $req = Request::all();

        $daysAgo = date('Y-m-d', strtotime('-3 day' , strtotime(date('Y-m-d'))));
        $today = date('Y-m-d', strtotime('-1 day' , strtotime(date('Y-m-d'))));
        
        if(isset($req['id']) && !empty($req['id'])) {
            $rules = [
                'title_promo'       => 'required',
                'description_promo' => 'required',
                //'featured_image'    => 'mimes:jpg,jpeg,png,gif',
                'featured_image'    => 'image|mimes:jpg,jpeg,png,gif|dimensions:max_width=2880,max_height=800|max:1024',
                //'start_date'        => 'required|date|after:'.$daysAgo,
                //'end_date'          => 'required|date|after:start_date|after:'.$today,
                'start_date'        => 'date|after:'.$daysAgo,
                'end_date'          => 'date|after:start_date|after:'.$today,
                'category'          => 'required',
                'featured_image_link'   => 'url'
            ];

            if (isset($req['discount_type'])){
                //$rules['discount'] = 'required|numeric|max:99|min:1';
                $rules['discount'] = 'numeric|max:99|min:1';
            }else{
                //$rules['discount_nominal'] = 'required|numeric|min:1';
                $rules['discount_nominal'] = 'numeric|min:1';
            }


            return $rules;

        } else {
            $rules = [
                'title_promo'       => 'required',
                'description_promo' => 'required',
                //'featured_image'    => 'required|mimes:jpg,jpeg,png,gif',
                'featured_image'    => 'required|image|mimes:jpg,jpeg,png,gif|dimensions:max_width=2880,max_height=800|max:1024',
                //'start_date'        => 'required|date|after:'.$daysAgo,
                //'end_date'          => 'required|date|after:start_date|after:'.$today,
                'start_date'        => 'date|after:'.$daysAgo,
                'end_date'          => 'date|after:start_date|after:'.$today,
                'category'          => 'required',
                'featured_image_link'   => 'url'
            ];

            if (isset($req['discount_type'])){
                //$rules['discount'] = 'required|numeric|max:99|min:1';
                $rules['discount'] = 'numeric|max:99|min:1';
            }else{
                //$rules['discount_nominal'] = 'required|numeric|min:1';
                $rules['discount_nominal'] = 'numeric|min:1';
            }

            return $rules;
                
        }

        
    }
}
