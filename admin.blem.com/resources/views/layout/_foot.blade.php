<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script>
    //二级菜单
    $('#on_set').on('click',function(){
        $('#set').toggle();
    })

    $('#set a').on('mouseover',function(){
        $(this).css('background','#DFF0D8');
    }).on('mouseout',function(){
        $(this).css('background','#8CBFC7');
    })

    //退出登录
    function logout(){
        $('#myModal').modal('hide');//关闭模态框
        location.href='./index.php?p=Admin&c=Login&a=logout';//跳转
    }
    //全选及全不选
    (function(){
        $('#ids').on('click',function(){
            $('#list input').prop('checked',$('#ids').prop('checked'));
        })
    })();

    //批量删除
    var ids = [];//数组,批量删除时存放所有id
    function dels(){
        $('.id').each(function(){
            if($(this).prop('checked')){
                ids.push($(this).prop('value'));//获取所有选中项的ID值
            }
        });

        $('#myModal').modal('hide');//关闭模态框

        $.ajax({
            type:'get',
            url:'moreDel&ids='+ids,
            success:function($data){
                if($data){
                    $(this).closest('tr').remove();
                    //提示
                    $('.content').append('<div class="suc" id="suc">批量删除成功 <span class="glyphicon glyphicon-ok"></span></div>');
                    $('#suc').fadeIn("500");
                    setTimeout(function(){
                        $('#suc').fadeOut("500");
                    },1000);
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            },
            error:function(){
                //删除失败
                $('.content').append('<div class="err" id="err">删除失败 <span class="glyphicon glyphicon-remove"></span></div>');
                $('#err').fadeIn("500");
                setTimeout(function(){
                    $('#err').fadeOut("500");
                },1000);
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        })
    }


    //删除功能
    function del(url){
        if(confirm('确定要删除吗？')){
            $.ajax({
                type:'delete',
                url:url,
                success:function($data){
                    console.log($data);
                    if($data == 1){
                        $(this).closest('tr').remove();
                        //提示
                        $('.content').append('<div class="suc" id="suc">删除成功 <span class="glyphicon glyphicon-ok"></span></div>');
                        $('#suc').fadeIn("500");
                        setTimeout(function(){
                            $('#suc').fadeOut("500");
                        },1000);
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                }
            })
        }
    }

</script>
</body>
</html>