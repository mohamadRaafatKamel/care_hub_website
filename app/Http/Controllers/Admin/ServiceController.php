<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $datas = Service::select()->paginate(PAGINATION_COUNT);
        return view('admin.service.index', compact('datas'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en'=>"unique:service,name_en",
        ]);
        try {
            if (!$request->has('disabled'))
                $request->request->add(['disabled' => 1]);

            $request->request->add(['admin_id' =>  Auth::user()->id ]);
            $image = $request->file('img');
            $imageName = "serv_".str_replace(' ', '_', $request->name_en) . ".". $image->extension();
            $image->move(public_path('service'),$imageName);
            $request->request->add(['image' =>  "public/service/".$imageName ]);
            Service::create($request->except(['_token']));
            return redirect()->route('admin.service')->with(['success'=>'تم الحفظ']);
        }catch (\Exception $ex){
            return redirect()->route('admin.service.create')->with(['error'=>'يوجد خطء']);
        }
    }

    public function edit($id)
    {
        $datas = Service::select()->find($id);
        if(!$datas){
            return redirect()->route('admin.service')->with(['error'=>"غير موجود"]);
        }
        return view('admin.service.edit',compact('datas'));
    }

    public function update($id, Request $request)
    {
        $vdata = Service::find($id);
        if ($request->name_en != $vdata->name_en ){
            $request->validate([
                'name_en'=>"unique:service,name_en",
            ]);
        }
        try {
            $data = Service::find($id);
            if (!$data) {
                return redirect()->route('admin.service.edit', $id)->with(['error' => '  غير موجوده']);
            }

            if (!$request->has('disabled'))
                $request->request->add(['disabled' => 1]);

            if ($request->has('img')){
                $image = $request->file('img');
                $imageName = "serv_".str_replace(' ', '_', $request->name_en) . ".". $image->extension();
                $image->move(public_path('service'),$imageName);
                $imgPath = "public/service/".$imageName;
            }else{
                $imgPath = $data->image;
            }
            $request->request->add(['image' => $imgPath]);

            $data->update($request->except(['_token']));

            return redirect()->route('admin.service')->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.service')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
    }

    public function destroy($id)
    {

        try {
            $data = Service::find($id);
            if (!$data) {
                return redirect()->route('admin.service', $id)->with(['error' => '  غير موجوده']);
            }
            $data->delete();

            return redirect()->route('admin.service')->with(['success' => 'تم حذف  بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.service')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
    }
}
