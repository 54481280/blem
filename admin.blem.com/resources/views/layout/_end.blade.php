</div>
</div>
</div>
</div>
<!--modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">批量删除操作</h4>
            </div>
            <div class="modal-body">
                确定删除吗？(请谨慎操作)
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" style="float: left;" id="dels" onclick="dels();">确定删除</button>
                <button type="button" class="btn btn-primary" aria-label="Close" data-dismiss="modal">取消删除</button>
            </div>
        </div>
    </div>
</div>
<!--logout-->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logoutAdmin">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="logoutAdmin">退出登录</h4>
            </div>
            <div class="modal-body">
                确定要退出后台系统吗？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" style="float: left;" onclick="logout();">确定</button>
                <button type="button" class="btn btn-primary" aria-label="Close" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>