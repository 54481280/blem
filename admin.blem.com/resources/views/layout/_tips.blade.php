{{--提示语--}}
@foreach(['success','info','warning','danger'] as $status)
    @if(session()->has($status))
        <div class="alert alert-{{$status}} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong style="margin-bottom: 10px;display: block">信息提示：</strong>
        <div class="alert alert-{{$status}}" role="alert">{{session($status)}}</div>
        </div>
    @endif
@endforeach