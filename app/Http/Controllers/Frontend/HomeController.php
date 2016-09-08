<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Homepage;
use App\Models\Event;
use App\Models\Category;
use App\Models\ManagePage;
//use View;

class HomeController extends Controller
{
    public function __construct(Homepage $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $result['sliders'] = $this->model->getHomepage('slider');
        $result['events'] = $this->model->getHomepage('event');
        $result['promotions'] = $this->model->getHomepage('promotion');
        $result['src'] = url('uploads/events').'/';
        $result['src2'] = url('uploads/promotions').'/';
        return view('frontend.partials.homepage', $result); 
    }

    public function discover(Request $req)
    {
        $result['sliders'] = $this->model->getHomepage('slider');
        $result['src'] = url('uploads/events').'/';
        $modelCategory = new Category();
        $result['categories'] = $modelCategory->getCategory();
        $modelEvent = new Event();
        $limit = 9;
        $result['events'] = $modelEvent->getEvent($limit);
        if($req->ajax()){      
            $events = $result['events'];

            if($events) {

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'success',
                    'data' => $events
                ],200);

            } else {

                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'data' => array(),
                    'message' => trans('general.data_empty')
                ],400);
            
            }
            
        }else{
            return view('frontend.partials.discover', $result);
        }
        
    }

    public function promotion(Request $req)
    {
        $modelEvent = new Event();
        $limit = 9;
        $result['events'] = $modelEvent->getEventByPromotion($limit);

        if($req->ajax()){      
            $events = $result['events'];

            if($events) {

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'success',
                    'data' => $events
                ],200);

            } else {

                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'data' => array(),
                    'message' => trans('general.data_empty')
                ],400);
            
            }
            
        }else{
            return view('frontend.partials.promotion', $result);
        } 
    }

    function pageContent($slug){
        $modelPage = new ManagePage();
        $page = $modelPage->findPagePublish($slug);
        if(!empty($page)){
            $content = $page->content;
        }else{
            $content = '<p>'.trans('general.data_not_found').'</p>';
        }

        return $content;
    }

    function preview($slug){
        $modelPage = new ManagePage();
        $page = $modelPage->findPageBySlug($slug);
        if(!empty($page)){
            $content = $page->content;
        }else{
            $content = '<p>'.trans('general.data_not_found').'</p>';
        }

        return $content;
    }

    public function careers(Request $req)
    {
        $param = $req->all();
        if(!empty($param)){
            if(isset($param['preview'])){
                $data['content'] = $this->preview('careers');
            }else{
                $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
            }
        }else{
            $data['content'] = $this->pageContent('careers');
        }
        
        return view('frontend.partials.careers', $data);
    }

    public function contactUs(Request $req)
    {
        return view('frontend.partials.contact_us');
    }

    public function ourCompany(Request $req)
    {   
        $param = $req->all();
        if(!empty($param)){
            if(isset($param['preview'])){
                $data['content'] = $this->preview('about-us');
            }else{
                $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
            }
        }else{
            $data['content'] = $this->pageContent('about-us');
        }
        return view('frontend.partials.our_company', $data);
    }

    public function supportFaq(Request $req)
    {
        return view('frontend.partials.support_faq');
    }

    public function supportWayToBuyTickets(Request $req)
    {
        $param = $req->all();
        if(!empty($param)){
            if(isset($param['preview'])){
                $data['content'] = $this->preview('way-to-buy-tickets');
            }else{
                $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
            }
        }else{
            $data['content'] = $this->pageContent('way-to-buy-tickets');
        }
        return view('frontend.partials.support_way_to_buy_tickets', $data);
    }

    public function searchResult()
    {
        return view('frontend.partials.search_result');
    }
}
