@extends('admin.layout.layout')
@section('content')
    <style>
        .page-item {
            display: inline-block;
        }
    </style>
    <body>

    <form method="post" action="" id="listform">
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 内容列表</strong> <a href=""
                                                                                   style="float:right; display:none;">添加字段</a>
            </div>
            <div class="padding border-bottom">
                <ul class="search" style="padding-left:10px;">
                    <li><a class="button border-main icon-plus-square-o" href="{{url('admin/article/create')}}">
                            添加内容</a></li>

                </ul>
            </div>
            <table class="table table-hover text-center">
                <tr>
                    <th width="100" style="text-align:left; padding-left:20px;">ID</th>
                    <th>图片</th>
                    <th>名称</th>
                    <th>浏览量</th>
                    <th>分类名称</th>
                    <th width="10%">更新时间</th>
                    <th width="310">操作</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value=""/>
                            {{$loop->iteration}}</td>

                        <td width="10%"><img src="/{{$article->image_url}}" alt="" width="70" height="50"/></td>
                        <td>{{$article->title}}</td>

                        <td>{{$article->views}}</td>
                        <td>{{$article->name}}</td>
                        <td>{{date('Y-m-d H:i:s',$article->updated_at)}}</td>
                        <td>
                            <div class="button-group"><a class="button border-main"
                                                         href="{{url('admin/article/'.$article->id.'/edit')}}"><span
                                            class="icon-edit"></span> 修改</a> <a class="button border-red"
                                                                                href="javascript:void(0)"
                                                                                onclick="delArticle({{$article->id}});"><span
                                            class="icon-trash-o"></span> 删除</a></div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="8">{{$articles->links()}}</td>
                </tr>
            </table>
        </div>
    </form>
    <script type="text/javascript">

        //单个删除
        function delArticle(id) {
            var _token = "{{csrf_token()}}";
            layer.confirm('你确定要删除这个文章吗？', function () {
                $.ajax({
                    url: "/admin/article/" + id,
                    type: 'delete',
                    datatype: 'json',
                    data: {_token: _token},
                    success: function (res) {
                        if (res.status == 'success') {
                            window.parent.location.href = "{{('/admin/index')}}";
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