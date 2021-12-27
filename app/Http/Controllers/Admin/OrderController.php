<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Emarh;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Requests;
use App\Models\Service;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::Selection()->paginate(PAGINATION_COUNT);
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {
        $serves = Service::select()->active()->get();
        $specialtys = Specialty::select()->active()->get();
        $doctors = User::select()->doctor()->get();
        $users = User::select()->get();
        $governorates = Governorate::select()->get();
        $citys = City::select()->get();

        if (isset($_GET['order'])) {
            $myorder = Order::select()->find($_GET['order']);
            if(!isset($myorder->id))
                return redirect()->route('admin.order');

        } elseif (isset($_GET['req'])) {
            $myreq = Requests::select()->find($_GET['req']);
            if($myreq->state == 1){
                $myorder = Order::select()->where('request_id',$_GET['req'])->first();
            }else{
                $myorder = Order::select()->find('0');
                if(!isset($myreq->id))
                    return redirect()->route('admin.request');
                $myorder->user_id = $myreq->user_id;
                $myorder->phone = $myreq->phone;
                $myorder->specialty_id  = $myreq->specialty_id ;
                $myorder->service_id  = $myreq->service_id ;
                $myorder->type = $myreq->type;
                $myorder->emergency = $myreq->emergency;
                $myorder->visit_time_day = $myreq->visit_time_day;
                $myorder->visit_time_from = $myreq->visit_time_from;
                $myorder->visit_time_to = $myreq->visit_time_to;
                $myorder->req_id = $myreq->id;
                $myorder->request_id = $myreq->type;
                if (isset($myreq->user_id) and $myreq->user_id != null){
                    $patient = User::select()->find($myreq->user_id);
                    if (isset($patient->id)){
                        $myorder->fullname = $patient->fname. " ".$patient->lname;
                        $myorder->governorate_id = $patient->governorate_id;
                        $myorder->city_id  = $patient->city_id ;
                        $myorder->adress = $patient->address;
                        $myorder->adress2 = $patient->address2;
                        $myorder->gender = $patient->gender;
                        $myorder->phone2 = $patient->mobile;
                        $myorder->birth_date = $patient->birth_date;
                    }
                }
            }
        } else {
            $myorder = Order::select()->find('0');
        }

        return view('admin.order.create',compact('users','doctors','governorates','citys','specialtys','serves','myorder'));
    }

    public function store(Request $request)
    {
        try {

//            if (!$request->has('emergency'))
//                $request->request->add(['emergency' => 0]);
//            if(isset())

            $request->request->add(['admin_id' =>Auth::user()->id]);
            if (isset($request->order_id) and $request->order_id != 0){
                $dataOrder = Order::find($request->order_id);
                if(isset($dataOrder->id)) {
                    $dataOrder->update($request->all());
                    return redirect()->route('admin.order.create')->with(['success' => 'تم الحفظ']);
                }
            }
            if (isset($request->order_id))
                $request->order_id= null;


            if (isset($request->request_id)){
                $myrequest = Requests::find($request->request_id);
                if (isset($myrequest->id)){
                    $myrequest->update(['state'=>'1']);
                    Order::create($request->except(['_token']));
                    return redirect()->route('admin.order.create')->with(['success' => 'تم الحفظ']);
                }else
                    $request->request_id = null;
            }

            Order::create($request->except(['_token']));
            return redirect()->route('admin.order.create')->with(['success'=>'تم الحفظ']);
        }catch (\Exception $ex){
            return redirect()->route('admin.order.create')->with(['error'=>'يوجد خطء']);
        }
    }

    public function getUserInfo($id = 0){
        // get records from database
        if($id!=0){
            $arr = User::select()->find($id);
        }else{
            $arr['price'] = 0;
        }
        echo json_encode($arr);
        exit;
    }


}
