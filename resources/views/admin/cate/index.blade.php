@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 分类列表</strong></div>
        <div class="padding border-bottom">
            <button type="button" class="button border-yellow"
                    onclick="window.location.href='{{url('admin/cate/create')}}'"><span
                        class="icon-plus-square-o"></span> 添加分类
            </button>
        </div>
        @if(!empty($cates))
            <table class="table table-hover text-center">
                <tr>
                    <th width="10%">ID</th>
                    <th width="20%">分类名称</th>
                    <th width="30%">分类描述</th>
                    <th width="40%">操作</th>
                </tr>
                @foreach($cates as $cate)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$cate['name']}}</td>
                        <td>{{$cate['desc']}}</td>
                        <td>
                            <div class="button-group">
                                <a class="button border-main" href="{{url('admin/cate/'.$cate['id'].'/edit')}}"><span
                                            class="icon-edit"></span> 修改</a>
                                <a class="button border-red" href="javascript:void(0)"
                                   onclick="destroy({{$cate['id']}});"><span class="icon-trash-o"></span> 删除</a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </table>
        @else
            你还没有分类，请先去添加！
        @endif

    </div>
    <script type="text/javascript">
        function destroy(id) {
            var _token = "{{csrf_token()}}";
            layer.confirm("确定要删除这个分类吗", function () {
                $.ajax({
                    type: 'delete',
                    url: '/admin/cate/' + id,
                    datatype: 'json',
                    data: {_token: _token},
                    success: function (res) {
                        if (res.status == 'success') {
                            window.parent.location.href = "{{url('admin/index')}}";
                        } else {
                            layer.alert(res.msg, {icon: 2});
                        }
                    }
                });
            });
        }
    </script>

    </body>
@endsection