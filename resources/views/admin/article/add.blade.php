@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加内容</strong></div>
        <div class="body-content">
            <form method="post" id="form" class="form-x" action="{{url('admin/article')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="label">
                        <label>文章标题：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" value="" name="title" datatype="s4-100"/>
                        <div class="tips"></div>
                    </div>
                </div>


                <if condition="$iscid eq 1">
                    <div class="form-group">
                        <div class="label">
                            <label>分类标题：</label>
                        </div>
                        <div class="field">
                            <select name="cate_id" class="input w50">
                                <option value="">请选择分类</option>
                                @if(!empty($cates))
                                    @foreach($cates as $cate)
                                        <option value="{{$cate['id']}}">{{$cate['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="tips"></div>
                        </div>
                    </div>

                </if>
                <div class="form-group">
                    <div class="label">
                        <label>关键字标题：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="keywords" value="" datatype="s2-8"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>描述：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" name="desc" style=" height:90px;"></textarea>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>图片：</label>
                    </div>
                    <div class="field">
                        <div id="uploader-demo">
                            <!--用来存放item-->
                            <div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>

                        </div>
                        <div class="tipss">图片尺寸：500*500</div>
                    </div>
                </div>

                <div class="form-group" style="display:none;">
                    <div class="label">
                        <label>内容：</label>
                    </div>
                    <div class="field">
                        <textarea name="content" id="text" class="input"
                                  style="height:450px; border:1px solid #ddd;"></textarea>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>内容：</label>
                    </div>
                    <div class="field">
                        <div id="editor">
                            <p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>
                        </div>
                    </div>
                </div>


                <div class="clear"></div>

                <div class="form-group">
                    <div class="label">
                        <label>作者：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" name="author" value="" datatype="s2-10"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: "{{asset('lib/webuploader/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{url('admin/upload')}}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',
            fileSingleSizeLimit: 1024 * 1024 * 2,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, res) {
            $("#uploader-demo").append('<img style="position:absolute;width:200px;height:100px;margin-left:300px;margin-top:-50px;" src=/' + res.url + '>');

            $("#uploader-demo").append('<input type="hidden" name="image_url" value=' + res.url + '>');
        });

        var E = window.wangEditor;
        var editor = new E('#editor');
        // 配置服务器端地址
        editor.customConfig.uploadImgServer = "{{url('article/upload')}}";
        editor.customConfig.uploadFileName = 'file';
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $("#text").val(html);
        }
        // 或者 var editor = new E( document.getElementById('editor') )
        editor.create();

    </script>
    <script>
        $("#form").Validform({
            tiptype: 4,
            ajaxPost: true,
            callback: function (res) {
                if (res.status == 'success') {
                    window.parent.location.href = "{{url('admin/index')}}";
                } else {
                    layer.alert(res.msg, {icon: 2});
                }
            }
        });
    </script>
    </body>
@endsection