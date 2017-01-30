<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Image;

class VisaCheckout extends Model
{
    use SoftDeletes;
    protected $table = 'visa_checkouts';
    protected $dates = ['deleted_at'];

    public function Events()
    {
        return $this->belongsToMany('App\Models\Event', 'event_categories', 'visa_checkout_id', 'event_id');

    }

    /**
     * Return venue's query for Datatables.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function datatables()
    {
        return static::select('id', 'title', 'banner_image', 'availability_homepage', 'sort_order')
            ->orderBy('sort_order', 'asc');
    
    }

    public function getFirstSort(){
        return VisaCheckout::orderBy('sort_order', 'asc')->first();
    }

    public function getLastSort(){
        return VisaCheckout::orderBy('sort_order', 'desc')->first();
    }

    public function getSortById($id){
        return VisaCheckout::where('id', $id)->first();
    }

    public function getOtherSort($id, $order){
        $data = $this->find($id);
        if(!empty($data)){
            $sort_no = $data->sort_order;
            if($order == 'asc'){
                if($sort_no == 0){
                    $result = VisaCheckout::select('id', 'sort_order')->where('sort_order', '<=', $sort_no)
                    ->orderBy('sort_order', 'desc')->orderBy('created_at', 'desc')->first();
                }else{
                    $result = VisaCheckout::select('id', 'sort_order')->where('sort_order', '<', $sort_no)
                    ->orderBy('sort_order', 'desc')->orderBy('created_at', 'desc')->first();
                }
            }else{
                if($sort_no == 0){
                    $result = VisaCheckout::select('id', 'sort_order')->where('sort_order', '>=', $sort_no)
                    ->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->first();
                }else{
                    $result = VisaCheckout::select('id', 'sort_order')->where('sort_order', '>', $sort_no)
                    ->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->first();
                }
            }
            return $result;
        }else{
            return false;
        }
    }

    public function updateCurrentSortOrder($param)
    {
        $id = $param['id_current'];
        $order = $param['order'];

        $data = $this->getSortById($id);
        $other = $this->getOtherSort($id, $order);
        $current_sort = $data->sort_order;

        if($other->sort_order == 0){
            $last = $this->getLastSort();
            $data->sort_order = $last->sort_order + 1;
        }else{
            $data->sort_order = $other->sort_order;
        }

        if($data->save()) {
            $data2 = $this->getSortById($other->id);
            if($current_sort == 0){
                $last = $this->getLastSort();
                $data2->sort_order = $last->sort_order + 1;
            }else{
                $data2->sort_order = $current_sort;
            }
            if($data2->save()) {
                return $data2;
            } else {

                return false;

            }
        } else {

            return false;

        }
    }


    /**
     * Insert new data venue
     * @return [type]
     */
    function insertNewVisaCheckout($param)
    {
    	$this->title = $param['title'];
    	$this->link = $param['link'];
        $this->background_color = $param['background_color'];
        $last = $this->getLastSort();
        $this->sort_order = (empty($last)) ? 1 : $last->sort_order + 1;
        if (isset($param['banner_image'])) {
            $banner_image = $param['banner_image'];
            $extension = $banner_image->getClientOriginalExtension();
            $filename_banner_image = "banner_image".time().'.'.$extension;
            $this->banner_image = $filename_banner_image;
        }

        if (isset($param['banner_image_mobile'])) {
            $banner_image_mobile = $param['banner_image_mobile'];
            $extension = $banner_image_mobile->getClientOriginalExtension();
            $filename_banner_image_mobile = "banner_image_mobile".time().'.'.$extension;
            $this->banner_image_mobile = $filename_banner_image_mobile;
        }
    	if($this->save()){
            if (isset($banner_image)) {
                $img = Image::make($banner_image);
                $img_tmp = $img->stream();
                Storage::disk(env('FILESYSTEM_DEFAULT'))->put(
                    'visa_checkouts/'.$filename_banner_image, $img_tmp->__toString(), 'public'
                );
            }
            if (isset($banner_image_mobile)) {
                $img = Image::make($banner_image_mobile);
                $img_tmp = $img->stream();
                Storage::disk(env('FILESYSTEM_DEFAULT'))->put(
                    'visa_checkouts/'.$filename_banner_image_mobile, $img_tmp->__toString(), 'public'
                ); 
            }
            return $this;
        } else {
            return false;
        }
    }

    /**
     * Find venue data by id
     * @param id    id venue  
     * 
     * @return [type]
     */
    public function findVisaCheckoutByID($id)
    {
        $data = $this->find($id);
        if (!empty($data)) {
            if(isset($data->banner_image)){
                $data->src_banner_image = file_url('visa_checkouts/'.$data->banner_image, env('FILESYSTEM_DEFAULT'));
            }
            if(isset($data->banner_image_mobile)){
                $data->src_banner_image_mobile = file_url('visa_checkouts/'.$data->banner_image_mobile, env('FILESYSTEM_DEFAULT')); 
            }
            return $data;
        
        } else {
        
            return false;

        }
    }


    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    function updateVisaCheckout($param, $id)
    {
        $data = $this->find($id);
        if (!empty($data)) {
            $data->title = $param['title'];
            $data->link = $param['link'];
            $data->background_color = $param['background_color'];

            if($data->sort_order == 0){
                $last = $this->getLastSort();
                $data->sort_order = (empty($last)) ? 1 : $last->sort_order + 1;
            }

            if (isset($param['banner_image'])) {
                $oldImage = $data->banner_image;
                
                if(!empty($oldImage)){
                    file_delete('visa_checkouts/'.$oldImage, env('FILESYSTEM_DEFAULT'));
                }

                $banner_image = $param['banner_image'];
                $extension = $banner_image->getClientOriginalExtension();
                $filename_banner_image = "banner_image".time().'.'.$extension;
                $data->banner_image = $filename_banner_image;
            }
            if (isset($param['banner_image_mobile'])) {
                $oldImage2 = $data->banner_image_mobile; 

                if(!empty($oldImage2)){
                    file_delete('visa_checkouts/'.$oldImage2, env('FILESYSTEM_DEFAULT'));
                }
                $banner_image_mobile = $param['banner_image_mobile'];
                $extension = $banner_image_mobile->getClientOriginalExtension();
                $filename_banner_image_mobile = "banner_image_mobile".time().'.'.$extension;
                $data->banner_image_mobile = $filename_banner_image_mobile;
            }
            if($data->save()) {
                if(isset($param['banner_image'])){
                    $img = Image::make($banner_image);
                    $img_tmp = $img->stream();
                    
                    Storage::disk(env('FILESYSTEM_DEFAULT'))->put(
                        'visa_checkouts/'.$filename_banner_image, $img_tmp->__toString(), 'public'
                    );
                }
                if(isset($param['banner_image_mobile'])){
                    $img = Image::make($banner_image_mobile);
                    $img_tmp = $img->stream();
                    
                    Storage::disk(env('FILESYSTEM_DEFAULT'))->put(
                        'visa_checkouts/'.$filename_banner_image_mobile, $img_tmp->__toString(), 'public'
                    );
                }
                return $data;
            } else {
                return false;

            }
        
        } else {

            return false;

        }
    }
    
    /**
     * Delete data venue
     * @param  $id     venue id 
     * @return Response
     */
    public function deleteByID($id)
    {
        $data = $this->find($id);
        if(!empty($data)) {
            $data->delete();

            $oldImage = $data->banner_image;
            $oldImage2 = $data->banner_image_mobile;
            if(!empty($oldImage)){
                file_delete('visa_checkouts/'.$oldImage, env('FILESYSTEM_DEFAULT'));
            }
            if(!empty($oldImage2)){
                file_delete('visa_checkouts/'.$oldImage2, env('FILESYSTEM_DEFAULT'));
            }
            return $data;
        } else {
            return false;
        }
    }


    public function getVisaCheckout(){
        $datas = VisaCheckout::where('availability_homepage', true)->orderBy('sort_order', 'asc')->get();
        
        if(!empty($datas)){
            foreach ($datas as $key => $data) {
                if(isset($data->banner_image)){
                    $data->src_banner_image = file_url('visa_checkouts/'.$data->banner_image, env('FILESYSTEM_DEFAULT'));
                }
                if(isset($data->banner_image_mobile)){
                    $data->src_banner_image_mobile = file_url('visa_checkouts/'.$data->banner_image_mobile, env('FILESYSTEM_DEFAULT')); 
                }
            }
            return $datas;
        }else{
            return false;
        }
    }

    public function deleteImage($param, $id){
        $data = $this->find($id);
        if(!empty($data)) {
            if(isset($param['banner_image'])){
                $banner_image = $data->banner_image;
                $data->banner_image = null;
                if($data->save()){
                    if(!empty($banner_image)){
                        file_delete('visa_checkouts/'.$banner_image, env('FILESYSTEM_DEFAULT'));
                    }
                }else{
                    return false;
                }
            }
            if(isset($param['banner_image_mobile'])){
                $banner_image_mobile = $data->banner_image_mobile;
                $data->banner_image_mobile = null;
                if($data->save()){
                    if(!empty($banner_image_mobile)){
                        file_delete('visa_checkouts/'.$banner_image_mobile, env('FILESYSTEM_DEFAULT'));
                    }
                }else{
                    return false;
                }
            }
        } else {
            return false;
        }

    }

    public static function dropdown()
    {
        return static::orderBy('sort_order', 'asc')->lists('title', 'id');
    }

    public function getVisaCheckoutByEvent($event_id){
        $datas = VisaCheckout::select('visa_checkouts.title', 'banner_image', 'banner_image_mobile', 'link', 
            'visa_checkouts.background_color as background_color')
            ->join('event_visa_checkouts', 'visa_checkouts.id', '=', 'event_visa_checkouts.visa_checkout_id')
            ->join('events', 'events.id', '=', 'event_visa_checkouts.event_id')
            ->where('event_id', $event_id)
            ->orderBy('visa_checkouts.sort_order', 'asc')
            ->orderBy('visa_checkouts.title', 'asc')->get();

        if(!empty($datas)){
            foreach ($datas as $key => $data) {
                $data->src_banner_image = file_url('visa_checkouts/'.$data->banner_image, env('FILESYSTEM_DEFAULT'));
                $data->src_banner_image_mobile = file_url('visa_checkouts/'.$data->banner_image_mobile, env('FILESYSTEM_DEFAULT')); 
            }
            return $datas;
        }else{
            return false;
        }
    }

    public function changeAvailabilityHomepage($param, $id){
        $data = $this->find($id);
        if (!empty($data)) {
            $data->availability_homepage = $param['availability_homepage'];
            if($data->save()) {
                return $data;
            } else {
                return false;

            }
        
        } else {

            return false;

        }
    }
}
