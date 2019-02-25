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