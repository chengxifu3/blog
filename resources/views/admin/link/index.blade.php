@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 链接列表</strong></div>
        <div class="padding border-bottom">
            <button type="button" class="button border-yellow"
                    onclick="window.location.href='{{url('admin/link/create')}}'"><span
                        class="icon-plus-square-o"></span> 添加链接
            </button>
        </div>
        @if(!empty($links))
            <table class="table table-hover text-center">
                <tr>
                    <th width="10%">ID</th>
                    <th width="15%">名称</th>
                    <th width="10%">url</th>
                    <th width="5%">排序</th>
                    <th width="15%">操作</th>
                </tr>
                @foreach($links as $link)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$link['title']}}</td>
                        <td>{{$link['url']}}</td>
                        <td>{{$link['sort']}}</td>
                        <td>
                            <div class="button-group">
                                <a class="button border-main" href="{{url('admin/link/'.$link['id'].'/edit')}}"><span
                                            class="icon-edit"></span> 修改</a>
                                <a class="button border-red" href="javascript:void(0)"
                                   onclick="destroy({{$link['id']}});"><span class="icon-trash-o"></span> 删除</a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </table>
        @else
            你还没有友情链接，请先去添加！
        @endif

    </div>
    <script type="text/javascript">
        function destroy(id) {
            var _token = "{{csrf_token()}}";
            layer.confirm("确定要删除这个友情链接吗", function () {
                $.ajax({
                    type: 'delete',
                    url: '/admin/link/' + id,
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