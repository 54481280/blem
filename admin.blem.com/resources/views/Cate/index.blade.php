@extends('layout.index')
@section('content')
    <table class="table table-hover" id="list">
        <tr>
            <th><input type="checkbox" name="ids" id="ids" value="0"> ID</th>
            <th>管理员账号</th>
            <th>真实姓名</th>
            <th>头像</th>
            <th>联系电话</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        <tr class="active">
            <td><input type="checkbox" name="id" class="id" value=""> </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <button class="btn btn-warning" title="编辑" onclick="edit()"><span class="glyphicon glyphicon-pencil"></span></button>
                <button class="btn btn-danger" title="删除" onclick="del()"><span class="glyphicon glyphicon-trash"></span></button>
            </td>
        </tr>
    </table>
@stop