@extends('admin.layout.layout')
@section('content')
    <body>
    <form method="post" action="">
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 评论管理</strong></div>
            @if(!empty($comments))
                <table class="table table-hover text-center">
                    <tr>
                        <th width="80">ID</th>
                        <th>用户名</th>
                        <th>文章标题</th>
                        <th>评论内容</th>
                        <th width="160">评论时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($comments as $comment)
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$comment->id}}"/>
                                {{$loop->iteration}}</td>
                            <td>{{$comment->username}}</td>
                            <td>{{$comment->title}}</td>
                            <td>{{substr($comment->content,0,20).'...'}}</td>
                            <td>{{date('Y-m-d H:i:s',$comment->created_at)}}</td>
                            <td>
                                <div class="button-group"><a class="button border-red" href="javascript:void(0)"
                                                             onclick="delComment({{$comment->id}})"> 删除</a></div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">{{$comments->links()}}</td>
                    </tr>
                </table>
            @else
                没有数据
            @endif
        </div>
    </form>
    <script type="text/javascript">

        function delComment(id) {
            var _token = "{{csrf_token()}}";
            layer.confirm("你确定要删除这条留言吗？", function () {
                $.ajax({
                    url: '/admin/delComment/' + id,
                    data: {_token: _token},
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        if (res.status == 'success') {
                            layer.alert(res.msg);
                            window.location.href = "{{url('admin/comment')}}";
                        } else {
                            layer.alert(res.msg);
                        }
                    }
                });
            });
        }

        $("#checkall").click(function () {
            $("input[name='id[]']").each(function () {
                if (this.checked) {
                    this.checked = false;
                }
                else {
                    this.checked = true;
                }
            });
        })

        function DelSelect() {
            var Checkbox = false;
            $("input[name='id[]']").each(function () {
                if (this.checked == true) {
                    Checkbox = true;
                }
            });
            if (Checkbox) {
                var t = confirm("您确认要删除选中的内容吗？");
                if (t == false) return false;
            }
            else {
                alert("请选择您要删除的内容!");
                return false;
            }
        }

    </script>
    </body>
@endsection