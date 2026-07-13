<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\MsgException;
use App\Http\Requests\MessageRequest;
use App\Models\Faq;
use App\Repositories\MessageRepository;
use Illuminate\Database\QueryException;

class MessageController extends BaseController
{
    public function index(){

        $faqs = Faq::orderBy('sort','desc')->limit(3)->get();
        return view('web::message',compact('faqs'));
    }

    /**
     * 添加留言
     * @param MessageRequest $request
     * @param MessageRepository $messageRepository
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function store(MessageRequest $request,MessageRepository $messageRepository){
        try {
            if($messageRepository->groupByDayIpCount() >= 5){
                throw new MsgException("留言次數過多，請稍後再試");
            }
            $messageRepository->store($request->all());
            return $this->success('留言成功','我們會儘快聯係您','/message');
        }catch (MsgException $exception){
            return $this->error('留言失敗',$exception->getMessage(),'/message');
        }catch (QueryException $exception){

            return $this->error('留言失敗','系統出現未知錯誤','/message');
        }catch (\Exception $exception){
            return $this->error('留言失敗','系統出現未知錯誤','/message');
        }

    }
}
