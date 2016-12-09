<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\LogActivity;
use App\Models\Trail;
use App\Models\Homepage;
//use View;

class CategoriesController extends Controller
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function index(Request $req, $slug)
    {

        try{
            $modelHomepage = new Homepage();
            //$result['sliders'] = $modelHomepage->getHomepage('slider');
            $result['category'] = $this->model->findCategoryBySlug($slug);

            if(!empty($result['category']) && $result['category']->status){
                $id = $result['category']->id;
                $result['categories'] = $this->model->getCategory();
                $modelEvent = new Event();
                $limit = 2;
                $result['banner'] = $modelEvent->getEventBannerByCategory($id);
                $result['events'] = $modelEvent->getEventByCategory($id, $limit);
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

                    $trail = 'Category front end';
                    $insertTrail = new Trail();
                    $insertTrail->insertTrail($trail);

                    return view('frontend.partials.category', $result); 
                }
            }else{
                return view('errors.404');
                
            }
        
        } catch (\Exception $e) {

            $log['user_id'] = $this->currentUser->id;
            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertLogActivity($log);

            return view('errors.404');
        
        }
    }
}
