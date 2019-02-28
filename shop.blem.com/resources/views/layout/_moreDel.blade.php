<script>
    (function(){
        //批量删除id数组
        window.ids = [];
        //给总标签绑定点击事件
        $('#moreDelete').on('click',function(){
            $('.delId').prop('checked',$(this).prop('checked'));
            //获取所有选中元素的id
            $('.delId').each(function(){
                ids.push($(this).val());
            });
        })

        //给单个标签绑定事件
        $('.delId').on('click',function(){
            console.log($(this).val());
            //如果选中的话就，清除在ids中的id，如果没有选中就加上
            if(!$(this).prop('checked')){
                //删除对应元素id
                ids.splice(ids.indexOf($(this).val()),1);
            }else{
                ids.push($(this).val());
            }
        })


    })();
    //点击批量删除方法
    function moreDelete(){
        if(confirm('确定要一起删除吗？')){
            location.href='/moreDel?ids='+ids;
        }
    }

</script>