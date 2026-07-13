<?php

namespace App\Http\Controllers\Web;


use App\Models\Refund;
use App\Services\VehicleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RefundController extends BaseController
{
    public function index(){
        return view('web::order.refund');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'phone'=>['required','regex:/^09\d{8}$/'],
            'type'=>'required|numeric',
            'content'=>'required',
        ]);

        $count = Refund::whereBetWeen('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->where('ip',VehicleService::IP())->count();
        if($count>=3){
            return $this->error('提交頻繁','我們會儘快處理您已提交的請求','/refund');
        }

        try {

            $images = [];
            if($request->hasFile('pictures')){
                $pictures = $request->file('pictures');
                foreach($pictures as $picture){
                    $extension = $picture->getClientOriginalExtension();
                    $fileTypes = ['jpg','jpeg','png','gif','webp'];
                    $isInFileType = in_array($extension,$fileTypes);
                    if(!$isInFileType){
                        throw new \Exception('文件格式不合法');
                    }
                    $images[] = $picture->store('images');

                }
            }

            Refund::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'sex'=>$request->get('sex',0),
                'type'=>$request->type,
                'reason'=>$request->get('content'),
                'ip'=>VehicleService::IP(),
                'user_agent'=>VehicleService::userAgent(),
                'pictures'=>$images
            ]);
            return $this->success('您的請求已收到','我們會儘快處理您的請求','/refund');
        }catch (\Exception $exception){

            return $this->error('操作失敗','系統出現未知錯誤','/refund');
        }



    }
}
