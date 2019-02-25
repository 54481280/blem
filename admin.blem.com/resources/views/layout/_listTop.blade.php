<div class="col-md-12 act">
    <div style="float: left">
        <button type="button" class="btn btn-info" onclick="location.href='@yield('CreateUrl')';"> @yield('CreateStr') </button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"> 批量删除 </button>
    </div>
    <div style="float: left;margin-left: 20%">
        <form class="form-inline" action="@yield('SearchUrl')" method="get">
            <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">@yield('Search')</label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon @yield('logo_search')"></span> </div>
                    <input type="text" class="form-control" name="keyword" style="width: 400px;" id="exampleInputAmount" placeholder="@yield('Search')">
                </div>
            </div>
            @yield('searchDiv')
            <button type="submit" class="btn btn-primary">@yield('Search')</button>
        </form>
    </div>
    <div style="float: right;">
        <button class="btn btn-success" title="刷新页面" onclick="window.location.reload()"><span class="glyphicon glyphicon-refresh"></span></button>
    </div>
</div>
<div class="row col-md-offset-1 col-md-10 list">