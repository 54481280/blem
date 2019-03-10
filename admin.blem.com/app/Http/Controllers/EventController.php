<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventPrizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd(date('Y-m-d H:i:s',time(date('Y-m-d H:i:s'))));
        //商家抽奖列表
        if($keyword = $request->keyword){
            $rows = Event::where('title',"%$keyword%")->paginate(3);
        }else{
            $rows = Event::paginate(3);
        }

        return view('Event.index',compact('rows','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $minDate = date('Y-m-d H:i:s');//最小时间
        $maxDate = date('Y-m-d H:i:s',strtotime('+1 day'));//最小时间
        $date = date('Y-m-d',strtotime('+2 day'));
        //新增抽奖表单
        return view('Event.create',compact('minDate','maxDate','date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //新增活动功能

        //验证表单数据
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'signup_start' => 'required|date',//开始时间不能为空
            'signup_end' => 'required|date|after:signup_start',//结束时间不能为空
            'prize_date' => 'required|date|after:signup_end',//开奖日期在报名之后
            'signup_num' => 'required|integer',//报名人数必须为整数
        ],[
            'title.required' => '抽奖活动名称不能为空',
            'content.required' => '抽奖活动详情不能为空',
            'signup_start.required' => '开始报名时间不能为空',
            'signup_start.date' => '开始报名时间格式错误',
            'signup_end.required' => '结束报名时间不能为空',
            'signup_end.date' => '结束报名时间格式错误',
            'signup_end.after' => '结束报名时间必须在开始时间之后',
            'prize_date.required' => '开奖日期不能为空',
            'prize_date.date' => '开奖日期格式错误',
            'prize_date.after' => '开奖日期必须在报名结束时间之后',
            'signup_num.required' => '限制报名人数不能为空',
            'signup_num.integer' => '限制报名人数必须为整数',
        ]);

        //验证通过
        Event::create([
            'title' => $request->title,
            'content' => $request->content,
            'signup_start' => strtotime(str_replace('T',' ',$request->signup_start)),
            'signup_end' => strtotime(str_replace('T',' ',$request->signup_end)),
            'prize_date' => $request->prize_date,
            'signup_num' => $request->signup_num,
            'is_prize' => 0,
        ]);

        return redirect()->route('event.index')->with('success','新增活动成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //抽奖活动详情
        return view('Event.shows',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $minDate = date('Y-m-d H:i:s');//最小时间
        $maxDate = date('Y-m-d H:i:s',strtotime('+1 day'));//最小时间
        $date = date('Y-m-d',strtotime('+2 day'));
        //更新活动表单
        return view('event.edit',compact('event','minDate','maxDate','date'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Event $event)
    {
        //更新功能

        //验证表单数据
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'signup_start' => 'required|date',//开始时间不能为空
            'signup_end' => 'required|date|after:signup_start',//结束时间不能为空
            'prize_date' => 'required|after:signup_end',//开奖日期在报名之后
            'signup_num' => 'required|integer',//报名人数必须为整数
        ],[
            'title.required' => '抽奖活动名称不能为空',
            'content.required' => '抽奖活动详情不能为空',
            'signup_start.required' => '开始报名时间不能为空',
            'signup_start.date' => '开始报名时间格式错误',
            'signup_end.required' => '结束报名时间不能为空',
            'signup_end.date' => '结束报名时间格式错误',
            'signup_end.after' => '结束报名时间必须在开始时间之后',
            'prize_date.required' => '开奖日期不能为空',
            'prize_date.after' => '开奖日期必须在报名结束时间之后',
            'signup_num.required' => '限制报名人数不能为空',
            'signup_num.integer' => '限制报名人数必须为整数',
        ]);

        //验证通过
        $event->update([
            'title' => $request->title,
            'content' => $request->content,
            'signup_start' => strtotime(str_replace('T',' ',$request->signup_start)),
            'signup_end' => strtotime(str_replace('T',' ',$request->signup_end)),
            'prize_date' => $request->prize_date ,
            'signup_num' => $request->signup_num,
            'is_prize' => 0,
        ]);

        return redirect()->route('event.index')->with('success','更新活动成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //删除活动
        //判断该活动是否有用户报名
        if(!empty(EventMember::where('events_id',$event->id)->first())){
            return back()->with('danger','该活动已经有商家报名，删除失败！');
        }


        try{
            DB::transaction(function() use($event){
                //删除活动奖品表的数据
                EventPrizes::where('events_id',$event->id)->delete();
                //删除活动
                $event->delete();
            });

            return back()->with('success','删除成功');
        }catch (\Exception $exception){
            return back()->with('danger','删除失败');
        }
    }

    //添加抽奖商品表单
    public function prize(Event $event){
        return view('Event.prize',compact('event'));
    }

    //添加抽奖商品功能
    public function storePrize(Event $event,Request $request){
        //验证每一项数据
        for($i=0;$i<count($request->name);$i++){

            if(!$request->name[$i] && !$request->description[$i]){
                return back()->with('danger','每一项数据不能为空！');
            }
        }

        //添加商品
        for($i=0;$i<count($request->name);$i++){

            EventPrizes::create([
                'events_id' => $event->id,
                'name' => $request->name[$i],
                'description' => $request->description[$i],
                'member_id' => 0
            ]);
        }

        return redirect()->route('event.index')->with('success','添加奖品成功');

    }

    //开奖功能
    public function lottery(Event $event){
        //判断是否已抽奖
        if($event->is_prize){
            return back()->with('danger','不能重复抽奖');
        }

        //声明数组，保存此活动的参与商家id
        $dataUser = [];
        //声明数组保存此活动奖品id
        $dataPrize = [];
        //声明数组，保存随机的得奖结果,     用户id =》 奖品id
        $data = [];



        //获取此活动的奖品（id）
        $prizes = $event->getPrize;
        foreach($prizes as $prize){
            $dataPrize[] = $prize->id;
        }

        //获取该活动的报名商家（商家账号id）
        $users = $event->singUpUser;
        foreach($users as $user){
            $dataUser[] = $user->member_id;
        }

        //判断报名人数是否大于奖品数量
        if(count($dataUser) < count($dataPrize)){
            return back()->with('danger','报名人数少于奖品数量，抽奖失败');
        }

        /*
         * 开始抽奖
         */

        //获取奖品的个数
        $num = count($dataPrize);
        //随机抽奖
        for($i=0;$i<$num;$i++){
            //生成随机的用户（键名）
            $user = array_rand($dataUser);
            //生成随机的奖品（键名）
            $prize = array_rand($dataPrize);
            //存入结果数组中（值）
            $data[$dataUser[$user]] = $dataPrize[$prize];
            //删除已出现的用户和奖品
            unset($dataUser[$user]);
            unset($dataPrize[$prize]);
        }

        /*
         * 抽奖结束，写入数据表
         */
        try{
            //自动事务
            DB::transaction(function() use($data,$event){
                //修改抽奖商品表，得奖用户id
                foreach($data as $user => $prize){
                    EventPrizes::find($prize)->update(['member_id' => $user,]);
                }

                //修改抽奖活动表中的活动状态(已抽奖)
                $event->is_prize = 1;
                $event->save();

            });
            return back()->with('success','抽奖成功');
        }catch (\Exception $exception){
            return back()->with('danger','抽奖失败');
        }


    }
}
