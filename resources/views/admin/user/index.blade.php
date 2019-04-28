@extends('admin.layout.layout')
@section('content')
    <body>
    <form method="post" action="">
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 用户管理</strong></div>
            <div class="padding border-bottom">
                <ul class="search">
                    <li>
                        <button type="button" class="button border-green" id="checkall"><span class="icon-check"></span>
                            全选
                        </button>
                        <button type="submit" class="button border-red"><span class="icon-trash-o"></span> 批量删除</button>
                    </li>
                </ul>
            </div>
            @if(!empty($users))
                <table class="table table-hover text-center">
                    <tr>
                        <th width="120">ID</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$user->id}}"/>
                                {{$loop->iteration}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                                <div class="button-group">
                                    <a class="button border-red" href="javascript:void(0)"
                                       onclick="return delUser({{$user->id}});"><span class="icon-trash-o"></span>
                                        删除</a>
                                    <a class="button border-red" href="javascript:void(0)"
                                       onclick="return freezeUser({{$user->id}});"><span
                                                class="icon-trash-o"></span> @if($user->status == 1)冻结@else解冻@endif</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">{{$users->links()}}</td>
                    </tr>
                </table>
            @endif
        </div>
    </form>
    <script type="text/javascript">

        function delUser(id) {
            var _token = "{{csrf_token()}}";
            if (confirm("您确定要删除吗?")) {
                $.ajax({
                    url: "/admin/user/delUser/" + id,
                    datatype: 'json',
                    data: {_token: _token},
                    success: function (res) {
                        if (res.status == 'success') {
                            layer.alert(res.msg);
                            window.location.href = "{{url('admin/user')}}";
                        } else {
                            layer.alert(res.msg);
                        }
                    }
                });
            }
        }

        function freezeUser(id) {
            var _token = "{{csrf_token()}}";
            layer.confirm('你确定这个操作吗', function () {
                $.ajax({
                    url: '/admin/freezeUser/' + id,
                    type: 'get',
                    datType: 'json',
                    data: {_token: _token},
                    success: function (res) {
                        if (res.status == 'success') {
                            layer.alert(res.msg);
                            window.location.href = "{{url('admin/user')}}";
                        } else {
                            layer.alert(res.msg);
                        }
                    }
                });
            })
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