{{--提示语--}}
@if(count($errors) > 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong style="margin-bottom: 10px;display: block">错误提示：</strong>
        @foreach($errors->all() as $error)
            <p style="text-indent: 4em">{{$error}}</p>
        @endforeach
    </div>
@endif