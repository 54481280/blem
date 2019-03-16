<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //抽奖活动列表
    public function index(){
        //获取所有未开奖的抽奖活动
        $rows = Event::where('is_prize',0)->get();
        return view('Event.index',compact('rows'));
    }

    //报名活动
    public function singUp(Event $event){
        $signup_num = Redis::decr($event->id);

        if($signup_num < 0){
            Redis::incr($event->id);
            return back()->with('warning','抱歉，报名人数已满，下次早点吧');
        }

        //判断报名人数是否符合该活动人数限制
        $count = EventMember::where('events_id',$event->id)->count();
        if($count >= $event->signup_num){
            return back()->with('warning','抱歉，报名人数已满，下次早点吧');
        }
        //判断是否登录
        if(empty(Auth::user())){
            return back('danger','请先登录');
        }

        //判断用户是否已经报名
        if(!empty(EventMember::where('events_id',$event->id)->where('member_id',Auth::user()->id)->first())){
            return back()->with('warning','您已经报过这个抽奖活动了，不能重复报名');
        }

        EventMember::create([
           'events_id' => $event->id,
           'member_id' => Auth::user()->id,
        ]);

        return back()->with('success','报名成功');
    }

    //中奖名单
    public function nameList(){
        //获取所有已开奖的活动
        $rows = Event::where('is_prize',1)->get();
        return view('Event.nameList',compact('rows'));
    }
}
