@extends('admin.layout.layout')
@section('content')
    <body>

    <div class="panel admin-panel margin-top" id="add">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 增加分类</strong></div>
        <div class="body-content">
            <form method="post" id="form" class="form-x" action="{{url('admin/cate')}}">
                @csrf
                <div class="form-group">
                    <div class="label">
                        <label>分类名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" value="" name="name" datatype="s2-10"/>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>分类描述：</label>
                    </div>
                    <div class="field">
                        <textarea type="text" class="input" datatype="s6-100" name="desc" style="height:120px;"
                                  value=""></textarea>
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