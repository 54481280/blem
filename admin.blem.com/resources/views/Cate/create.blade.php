@extends('layout.form')
@section('path'){{--页面位置--}}
<li><a href="#">商家分类管理</a></li>
<li><a href="#">增加商家分类</a></li>
@stop
@section('content')
@include('layout._error')
    <form action="{{route('shop.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group row col-md-12">
            <label for="username">商家分类名称</label>
            <input type="text" class="form-control" id="username" name="name" value="{{old('name')}}" placeholder="请输入商家分类名称">
        </div>
        <div class="form-group row col-md-4">
            <label for="info_photo">选择商家分类图片</label>
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
                <input type="hidden" name="img" id="img_path"/>
            </div>
        </div>
        <div class="col-md-8">
            <img src="/images/00.jpg" id="autoImg" width="100" height="100" id="default">
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-success col-md-1">确定添加</button>
    </form>
<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        // swf: BASE_URL + '/js/Uploader.swf',

        // 文件接收服务端。
        server: '/autoFile',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

        //设置上传请求参数
        formData:{
            _token:'{{csrf_token()}}'
        }
    });
    //监听上传成功事件
    uploader.on('uploadSuccess',function(file,response){
        console.log(response);
        $('#autoImg').attr('src',response.path);
        $('#img_path').val(response.path);
    })
</script>
{{--@include('layout._showImg')--}}
@stop
