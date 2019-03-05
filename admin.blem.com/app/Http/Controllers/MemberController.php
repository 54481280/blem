<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = Member::paginate(5);//获取分页数据

        if($keyword = $request->keyword){
            $rows = Member::where('username','like',"%{$keyword}%")->paginate(5);//获取查询分页数据
        }

        return view('Member.index',compact('rows','keyword'));//返回页面及数据
    }

    //会员详情功能
    public function show(Member $member){
        //也可以用之前写接口的方式
        $member = DB::select('select m.id,m.username,m.tel,m.created_at,m.`status`,a.province,a.city,a.area,a.detail_address,a.tels,a.name from members as m join (select user_id,GROUP_CONCAT(province) as province,GROUP_CONCAT(city) as city,GROUP_CONCAT(area) as area,GROUP_CONCAT(detail_address) as detail_address,GROUP_CONCAT(tel) as tels,GROUP_CONCAT(name) as name from addresses GROUP BY user_id) as a on m.id = a.user_id where m.id = ?',[$member->id]);
        foreach($member as $row){
            $row->province = explode(',',$row->province);
            $row->city = explode(',',$row->city);
            $row->area = explode(',',$row->area);
            $row->detail_address = explode(',',$row->detail_address);
            $row->tels = explode(',',$row->tels);
        }

        return view('Member.show',compact('member'));
    }

    //商家状态功能
    public function status(Member $member){
        if($member->status){
            $status = 0;//如果该用户已启用，则更新为禁用
            $info = 'warning';
            $str = '禁用会员成功！';
        }else{
            $status = 1;//如果该用户为禁用，则更新为启用
            $info = 'success';
            $str = '启用会员成功！';
        }

        //更新
        $member->status = $status;
        $member->save();

        //更新成功，跳转页面，给出提示
        return redirect()->back()->with($info,$str);
    }
}
