<?php

namespace App\Http\Controllers;

use App\Models\Active;
use Illuminate\Http\Request;

class ActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $rows = Active::where('title','like',"%");//原始查询
        $date = date('Y-m-d H:i:s');//获取当前时间
        $data = [];//接收参数
        //如果有名称查询
        if($keyword = $request->keyword){
            $rows->where('title','like',"%$keyword%");
            //接收名称参数
            $data['keyword'] = $keyword;
        }

        //未开始的
        if($request->status == -1 ){
            $rows->where('start_time','>=',$date);

            //接收状态参数
            $data['status'] = -1;

        }

        //进行中
        if($request->status == 1){
            $rows->where('start_time','<=',$date)
                ->where('end_time','>=',$date);

            //接收状态参数
            $data['status'] = 1;

        }

        //已结束
        if($request->status == 2){
            $rows->where('end_time','<=',$date);

            //接收状态参数
            $data['status'] = 2;
        }

        $rows = $rows->paginate(5);//最终查询

        //活动列表
        return view('Active.index',compact('rows','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $minDate = date('Y-m-d H:i:s');//最小时间
        $maxDate = date('Y-m-d H:i:s',strtotime('+1 day'));


        //新增功能
        return view('active.create',compact('minDate','maxDate'));
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
        $this->validate($request,
            [
                'title' => 'required',//标题不能为空
                'content' => 'required',//活动内容不能为空
                'start_time' => 'required|date',//开始时间不能为空
                'end_time' => 'required|date|after:start_time',//结束时间不能为空
            ],[
                'title.required' => '标题不能为空',
                'content.required' => '活动内容不能为空',
                'start_time.required' => '开始时间不能为空',
                'start_time.date' => '开始日期时间格式错误',
                'end_time.required' => '结束时间不能为空',
                'end_time.date' => '结束日期时间格式错误',
                'end_time.after' => '结束日期时间必须在开始日期之后！',
            ]);

        //验证通过
        Active::create([
            'title' => $request->title,
            'content' => $request->content,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        //添加活动功能完成
        return redirect()->route('active.index')->with('success','新增活动成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Active $active)
    {
        $minDate = date('Y-m-d').'T'.date('H:i:s');//最小时间
        $maxDate = date('Y-m-d',strtotime('+1 day')).'T'.date('H:i:s');//最大时间
        //更新活动表单
        return view('active.edit',compact('active','minDate','maxDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Active $active)
    {
        //dd($request->input());
        //完成更新操作
        $this->validate($request,
            [
                'title' => 'required',//标题不能为空
                'content' => 'required',//活动内容不能为空
                'start_time' => 'required|date',//开始时间不能为空
                'end_time' => 'required|date|after:start_time',//结束时间不能为空
            ],[
                'title.required' => '标题不能为空',
                'content.required' => '活动内容不能为空',
                'start_time.required' => '开始时间不能为空',
                'start_time.date' => '开始日期时间格式错误',
                'end_time.required' => '结束时间不能为空',
                'end_time.date' => '结束日期时间格式错误',
                'end_time.after' => '结束日期时间必须在开始日期之后！',
            ]);

        //验证通过
        $active->update([
            'title' => $request->title,
            'content' => $request->content,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        //更新活动功能完成
        return redirect()->route('active.index')->with('success','更新活动成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
