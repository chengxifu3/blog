@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 网站信息</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="javascript:;">
                @csrf
                <div class="form-group">
                    <div class="label">
                        <label>网站标题：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input" name="title" value="{{$sys['title']}}"/>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>网站关键字：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" id="keywords" name="keywords"
                                  style="height:80px">{{$sys['keywords']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>网站描述：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" id="desc" name="desc">{{$sys['desc']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>作者：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" id="author" name="author">{{$sys['author']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>底部信息：</label>
                    </div>
                    <div class="field">
                        <textarea name="footer" id="footer" class="input"
                                  style="height:120px;">{{$sys['footer']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button id="submit" class="button bg-main icon-check-square-o" type="submit"> 保存</button>
                        <input type="hidden" name="id" value="{{$sys['id']}}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $("#submit").click(function () {
            var id = $("input[name='id']").val();
            var title = $("input[name='title']").val();
            var keywords = $("#keywords").val();
            var desc = $("#desc").val();
            var author = $("#author").val();
            var footer = $("#footer").val();
            var _token = "{{csrf_token()}}";
            $.post("{{url('admin/system/edit')}}", {
                id: id,
                title: title,
                keywords: keywords,
                desc: desc,
                author: author,
                footer: footer,
                _token: _token
            }, function (res) {
                if (res.status == 'success') {
                    window.parent.location.href = "{{url('admin/index')}}";
                } else {
                    layer.alert(res.msg);
                }
            });
        });
    </script>
    </body>
@endsection