@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家抽奖活动管理</a></li>
<li><a href="#">新增抽奖活动</a></li>
@stop
@section('content')
@include('layout._error')
@include('layout._tips')
    <form action="{{route('event.storePrize',[$event])}}" method="post" enctype="multipart/form-data" style="height: 600px;overflow-y:scroll;">
        <div id="prize">
        <div class="form-group row col-md-12" style="color: red">
            <label for="title">抽奖商品</label>
            <input type="text" class="form-control" id="title" name="name[]" value="{{old('title')}}" placeholder="请输入奖品名称">
        </div>

        <div class="form-group row col-md-12">
            <label for="content">奖品详情</label>
            <textarea class="form-control" rows="3" name="description[]"></textarea>
        </div>
        </div>
        {{csrf_field()}}
        <div class="form-group row col-md-12">
        <button type="button" class="btn btn-primary" onclick="addPrize()">增加奖品栏</button>
        <button type="submit" class="btn btn-success">完成奖品添加</button>
        </div>
    </form>

<!-- 配置文件 -->
<script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
<script>
    // 实例化编辑器
    var ue = UE.getEditor('container');
    var count = 1;
    function addPrize(){
        if(count<3) {
            html = "<div class=\"form-group row col-md-12\" style=\"color: red\">\n" +
                "            <label for=\"title\">抽奖商品</label>\n" +
                "            <input type=\"text\" class=\"form-control\" id=\"title\" name=\"name[]\" value=\"{{old('title')}}\" placeholder=\"请输入奖品名称\">\n" +
                "        </div>\n" +
                "\n" +
                "        <div class=\"form-group row col-md-12\">\n" +
                "            <label for=\"content\">奖品详情</label>\n" +
                "            <textarea class=\"form-control\" rows=\"3\" name=\"description[]\"></textarea>\n" +
                "        </div>"
            $('#prize').append(html);
                count ++;
        }else{
            alert('一次最多只能添加3个奖品');
        }
    }
</script>
@stop
@include('layout._showImg')