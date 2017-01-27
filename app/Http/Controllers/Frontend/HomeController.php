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
use App\Models\LogActivity;
use App\Models\Trail;
use App\Models\Department;
use App\Models\Career;
use App\Models\Message;
use App\Models\Subscription;
use App\Models\VisaCheckout;
use Mail;
use App\Http\Requests\Frontend\SendMessageRequest;
use App\Http\Requests\Frontend\FeedbackRequest;
use App\Http\Requests\Frontend\SubscribeRequest;
//use View;

class HomeController extends Controller
{
    public function __construct(Homepage $model)
    {
        parent::__construct($model);
    }

    public function landing()
    {

        return view('frontend.partials.static.bryan_adams'); 
    }

    public function maintenance()
    {

        return view('frontend.partials.static.maintenance'); 
    }

    public function indexStatic()
    {
        $trail['desc'] = 'Homepage Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);
        return view('frontend.partials.static.homepage_static'); 
    }

    public function bryanAdams()
    {
        $trail['desc'] = 'Event Bryan Adams Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.event_bryan_adams'); 
    }

    public function jessicaJungSingapore()
    {
        $trail['desc'] = 'Event Jessica Jung Singapore Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.event_jessica_jung_singapore'); 
    }

    public function jessicaJungHochiminh()
    {
        $trail['desc'] = 'Event Jessica Jung Hochiminh Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.event_jessica_jung_hochiminh'); 
    }

    public function jessicaJungManila()
    {
        $trail['desc'] = 'Event Jessica Jung Manila Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.event_jessica_jung_manila'); 
    }

    public function supportStatic()
    {

        $trail['desc'] = 'Support Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.support_static'); 
    }

    public function supportFaqStatic(Request $req)
    {
        $trail['desc'] = 'FAQ Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);
            
        return view('frontend.partials.static.support_faq_static');
    }

    public function supportFaqCategoryStatic($category)
    {
        $trail['desc'] = 'FAQ Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        if($category == 'top'){
            return view('frontend.partials.static.support_faq_top_static');
        }elseif ($category == 'general') {
            return view('frontend.partials.static.support_faq_general_static');
        }elseif ($category == 'payment') {
             return view('frontend.partials.static.support_faq_payment_static');
        }elseif ($category == 'seat') {
             return view('frontend.partials.static.support_faq_seat_static');
        }
    }

    public function contactUsStatic()
    {
        $trail['desc'] = 'Contact Us Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);
            
        return view('frontend.partials.static.contact_us_static');
    }

    public function supportTermsTicketSalesStatic()
    {
        $trail['desc'] = 'Terms Tickets Sales Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.support_terms_ticket_sales_static'); 
    }

    public function supportTermsWebsiteUseStatic()
    {
        $trail['desc'] = 'Terms Website Use Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.support_terms_website_use_static'); 
    }

    public function supportPrivacyPolicyStatic(Request $req)
    {

        $trail['desc'] = 'Privacy Policy Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);

        return view('frontend.partials.static.support_privacy_policy_static');
    }

    public function aboutUsStatic()
    {
        $trail['desc'] = 'About Us Static front end';
        $insertTrail = new Trail();
        $insertTrail->insertNewTrail($trail);
            
        return view('frontend.partials.static.about_us_static');
    }

    public function supportWaysToBuyTicketsStatic()
    {

        try{
            $trail['desc'] = 'Way to buy tickets Static front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.static.support_ways_to_buy_tickets_static');
            
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function index()
    {
        try{
            $result['sliders'] = $this->model->getHomepage('slider');
            $result['events'] = $this->model->getHomepage('event');
            $result['promotions'] = $this->model->getHomepage('promotion');
            $modelVisa = new VisaCheckout();
            $result['visas'] = $modelVisa->getVisaCheckout();

            $trail['desc'] = 'Homepage front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);


            return view('frontend.partials.homepage', $result); 
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);
        
        }
    }

    public function discover(Request $req)
    {

        try{
            $modelCategory = new Category();
            $result['categories'] = $modelCategory->getCategoryEventExist();
            $limit = 8;
            $modelEvent = new Event();
            $result['events'] = $modelEvent->getEvent($limit);
            $result['banner'] = $modelEvent->getEventBanner();
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

                $trail['desc'] = 'Discover front end';
                $insertTrail = new Trail();
                $insertTrail->insertNewTrail($trail);

                return view('frontend.partials.discover', $result);
            }
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
        
    }

    public function promotion(Request $req)
    {

            $modelEvent = new Event();
            $limit = 9;
            $result['events'] = $modelEvent->getEventByPromotion($limit);
            $result['currency_default'] = $this->setting['currency'];

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

                $trail['desc'] = 'Promotion front end';
                $insertTrail = new Trail();
                $insertTrail->insertNewTrail($trail);

                return view('frontend.partials.promotion', $result);
            } 
    }

    public function supports()
    {

        try{

            $trail['desc'] = 'Support front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.support'); 
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);
        
        }
    }

    function pageContent($slug){
        $modelPage = new ManagePage();
        $page = $modelPage->findPagePublish($slug);
        if(!empty($page)){
            $data['content'] = $page->content;
            $data['responsive_content'] = $page->responsive_content;
        }else{
            $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
            $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
        }

        return $data;
    }

    function preview($slug)
    {
        $page = (object) \Session::get('preview_'.$slug);
        if(!empty($page)){
            $data['content'] = $page->desktop_content;
            $data['responsive_content'] = $page->responsive_content;
        }else{
            $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
            $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
        }

        return $data;
    }

    public function ourCompanyCareers(Request $req)
    {
        try{
            
            $param = $req->all();
            $param['currency_default'] = $this->setting['currency'];
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('careers');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('careers');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $modelDepartment = new Department();
            $data['departments'] = $modelDepartment->getDepartment();
            $modelCareer = new Career();
            $data['careers'] = $modelCareer->getCareerByDepartment($param);
            if(!empty($data['careers'])){
                $data['count_job'] = count($data['careers']);
            }else{
                $data['count_job'] = 'No';
            }
            if($req->ajax()) {
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'success',
                    'data' => $data
                ],200);

            }else{
                $trail['desc'] = 'Careers front end';
                $insertTrail = new Trail();
                $insertTrail->insertNewTrail($trail);
        
                return view('frontend.partials.careers', $data);
            }
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function ourCompanyContactUs(Request $req)
    {
        try{
                
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('contact-us');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('contact-us');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Contact Us front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);
            
            return view('frontend.partials.contact_us', $data);
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function ourCompanyAboutUs(Request $req)
    {   
        try{
             
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('about-us');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('about-us');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Our company front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.our_company', $data);
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function supportFaq(Request $req)
    {
        try{
                
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('faq');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('faq');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'FAQ front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);
            
            return view('frontend.partials.support_faq', $data);
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function supportWaysToBuyTickets(Request $req)
    {

        try{
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('how-to-buy-tickets');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('how-to-buy-tickets');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Way to buy tickets front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.support_way_to_buy_tickets', $data);
            
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function supportTermsTicketSales(Request $req)
    {

        try{
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('terms-of-ticket-sales');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('terms-of-ticket-sales');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Terms and conditions front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.support_terms_ticket_sales', $data);
            
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function supportTermsWebsiteUse(Request $req)
    {

        try{
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('terms-of-website-use');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('terms-of-website-use');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Terms and conditions front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.support_terms_website_use', $data);
            
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function supportPrivacyPolicy(Request $req)
    {

        try{
            $param = $req->all();
            if(!empty($param)){
                if(isset($param['preview'])){
                    $preview = $this->preview('privacy-policy');
                    $data['content'] = $preview['content'];
                    $data['responsive_content'] = $preview['responsive_content'];
                }else{
                    $data['content'] = '<p>'.trans('general.data_not_found').'</p>';
                    $data['responsive_content'] = '<p>'.trans('general.data_not_found').'</p>';
                }
            }else{
                $page = $this->pageContent('privacy-policy');
                $data['content'] = $page['content'];
                $data['responsive_content'] = $page['responsive_content'];
            }

            $trail['desc'] = 'Privacy Policy front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.support_privacy_policy', $data);
            
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return view('errors.404');
        
        }
    }

    public function subscribeUs()
    {

        try{

            $trail['desc'] = 'Subscribe front end';
            $insertTrail = new Trail();
            $insertTrail->insertNewTrail($trail);

            return view('frontend.partials.subscribe'); 
        
        } catch (\Exception $e) {

            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

        
        }
    }

    public function subscribeUsStore(SubscribeRequest $req)
    {
        try{
            $param = $req->all();

            

            $modelSubscription = new Subscription();
            $findSubscriber = $modelSubscription->findByEmail($param['email']);
            if(!empty($findSubscriber)){
                $subscribe = $modelSubscription->updateSubscription($param, $param['email']);
                $text = 'update';
            }else{
                Mail::send('frontend.emails.subscribe_reply', $param, function ($message) use ($param) {
                    $message->to($param['email'], $param['first_name'].' '.$param['last_name'])->subject('Thanks for Your Subscription');

                    $modelSubscription = new Subscription();
                    $subscribe = $modelSubscription->insertNewSubscription($param);
                });
                $text = 'new';
            }

            if($req->ajax()){
                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => trans('general.subscribe_success'),
                    'data'  => $text,
                ],200);
            }else{
                if($text == 'new'){
                    flash()->success(trans('frontend/general.you_are_part_mailing_list'));
                }else{
                    flash()->error(trans('frontend/general.already_sucribed_us'));
                }
                
                return \Redirect::back();
            }
        
        } catch (\Exception $e) {
 
            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            if($req->ajax()){
                return response()->json([
                    'code' => 400,
                    'status' => 'success',
                    'message' => trans('general.subscribe_error')
                ],400);
            }else{
                flash()->error(trans('general.subscribe_error'));
                return \Redirect::back();
            }
        
        }
    }

    public function sendMessage(SendMessageRequest $req)
    {

        try{
            $param = $req->all();

            $data['mail_driver'] = $this->setting['mail_driver'];
            $data['mail_host'] = $this->setting['mail_host'];
            $data['mail_port'] = $this->setting['mail_port'];
            $data['mail_username'] = $this->setting['mail_username'];
            $data['mail_password'] = $this->setting['mail_password'];
            $data['mail_name'] = $this->setting['mail_name'];
            $param['body'] = $param['message'];

            Mail::send('frontend.emails.contact_us', $param, function ($message) use ($param, $data) {
                $message->from($param['email'], $param['name'])
                    ->to($data['mail_username'], $data['mail_name'])
                    ->subject($param['subject'])
                    ->replyTo($param['email'], $param['name']);

                $modelMessage = new Message();
                $inbox = $modelMessage->insertNewMessage($param);
            });

            Mail::send('frontend.emails.contact_us_reply', $param, function ($message) use ($data, $param) {
                $message->from($data['mail_username'], $data['mail_name'])
                    ->to($param['email'], $param['name'])->subject('Thank You')
                    ->replyTo($data['mail_username'], $data['mail_name']);
            });

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => trans('general.message_success')
            ],200);
        } catch (\Exception $e) {
 
            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return response()->json([
                'code' => 400,
                'status' => 'success',
                'message' => trans('general.message_error')
            ],400);
        
        }
    }

    public function feedBack(FeedbackRequest $req)
    {

        try{
            $param = $req->all();

            $data['mail_driver'] = $this->setting['mail_driver'];
            $data['mail_host'] = $this->setting['mail_host'];
            $data['mail_port'] = $this->setting['mail_port'];
            $data['mail_username'] = $this->setting['mail_username'];
            $data['mail_password'] = $this->setting['mail_password'];
            $data['mail_name'] = $this->setting['mail_name'];
            $param['body'] = $param['message'];

            Mail::send('frontend.emails.feedback', $param, function ($message) use ($param, $data) {
                $message->from($param['email'])
                    ->to($data['mail_username'], $data['mail_name'])
                    ->subject($param['subject'])
                    ->replyTo($param['email']);

                $modelMessage = new Message();
                $inbox = $modelMessage->insertNewMessage($param);
            });

            Mail::send('frontend.emails.feedback_reply', $param, function ($message) use ($data, $param) {
                $message->from($data['mail_username'], $data['mail_name'])
                    ->to($param['email'])->subject('Thanks for Your Feedback')
                    ->replyTo($data['mail_username'], $data['mail_name']);
            });

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => trans('general.message_success')
            ],200);
        } catch (\Exception $e) {
 
            $log['description'] = $e->getMessage().' '.$e->getFile().' on line:'.$e->getLine();
            $insertLog = new LogActivity();
            $insertLog->insertNewLogActivity($log);

            return response()->json([
                'code' => 400,
                'status' => 'success',
                'message' => trans('general.message_error')
            ],400);
        
        }
    }
}
