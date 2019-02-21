<div class="row content">
    <div class="col-md-12" style="margin-top:20px">
        <ol class="breadcrumb">
            <li><a href="#">后台系统</a></li>
            <li><a href="#">管理员管理</a></li>
        </ol>
    </div>
    <div class="col-md-12 act">
        <div style="float: left">
            <button type="button" class="btn btn-info" onclick="location.href='';"> 添加管理员 </button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"> 批量删除 </button>
        </div>
        <div style="float: left;margin-left: 20%">
            <form class="form-inline" action="adminList" method="post">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">搜索管理员</label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </div>
                        <input type="text" class="form-control" name="key" style="width: 400px;" id="exampleInputAmount" placeholder="请输入管理员名称">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">搜索管理员</button>
            </form>
        </div>
        <div style="float: right;">
            <button class="btn btn-success" title="刷新页面" onclick="window.location.reload()"><span class="glyphicon glyphicon-refresh"></span></button>
        </div>
    </div>
    <div class="row col-md-offset-1 col-md-10 list">