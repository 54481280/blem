<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style>
        body{
            overflow: hidden;
            background: url("/images/banner.jpg");
            background-size: cover;
        }
        .login{
            height: 550px;
            background-color: rgba(240, 110, 75, 0.67);
            border-bottom-left-radius:20%;
            border-bottom-right-radius:20%;
        }

        .content{
            width: 70%;
            margin: 100px auto;
            opacity: 1;
        }
        .content h2{
            color: #f5f5f5;
            font-family: "SimSun", "宋体", "Arial Narrow";
        }
        .adm{
            margin: 20px 0;
        }
        .content button{
            margin-right:50px;
        }

    </style>
</head>
<body>
    <div class="row">
        <div class="col-md-offset-3 col-md-3" style="padding: 200px 50px">
            @if(count($errors) > 0)
            <div class="alert alert-danger" role="alert" style="padding: 50px 20px;font-size: 17px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong style="margin-bottom: 10px;display: block;font-size: 22px">错误提示:</strong>
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
            @endif
            @foreach(['success','info','warning','danger'] as $status)
                @if(session()->has($status))
                        <div class="alert alert-{{$status}}" role="alert" style="padding: 50px 20px;font-size: 17px">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong style="margin-bottom: 10px;display: block;font-size: 22px">错误提示:</strong>
                        <div class="alert alert-{{$status}}" role="alert">{{session($status)}}</div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-md-offset-2 col-md-3 login">
            <div class="content">
                <h2>商家登录</h2><hr/>
                <form action="{{route('login')}}" method="post" enctype="multipart/form-data">
                    <div class="input-group adm">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </div>
                        <input type="text" class="form-control" name="name" style="width: 300px;" value="{{old('name')}}" id="exampleInputAmount" placeholder="请输入管理员账号">
                    </div>
                    <div class="input-group adm">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span> </div>
                        <input type="password" class="form-control" name="password" style="width: 300px;" id="" placeholder="请输入管理员密码">
                    </div>
                    <div class="input-group adm">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-paperclip"></span> </div>
                        <input type="text" class="form-control" name="captcha" style="width: 300px;" id="exampleInputAmount" placeholder="请输入验证码">
                    </div>
                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                    <p><a href="{{route('user.create')}}" style="color: #eee;">还没有自己的商户？立即注册</a> </p>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rember" value="1"> 记住登录
                        </label>
                    </div>
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-success">登录</button>
                    <button type="reset" class="btn btn-warning">重置</button>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>