@extends('admin.layout.layout')
@section('content')
    <body>

    <div class="panel admin-panel margin-top" id="add">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 增加链接</strong></div>
        <div class="body-content">
            <form method="post" id="form" class="form-x" action="{{url('admin/link')}}">
                @csrf
                <div class="form-group">
                    <div class="label">
                        <label>标题：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" value="" name="title" datatype="s2-20"/>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>URL：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" datatype="url" name="url" value=""/>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>排序：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" name="sort" value="0" datatype="n"/>
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