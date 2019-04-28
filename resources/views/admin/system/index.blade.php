@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 网站信息</strong></div>
        <div class="body-content">
            <form method="post" class="form-x" action="">
                <div class="form-group">
                    <div class="label">
                        <label>网站标题：</label>
                    </div>
                    <div class="field">
                        <input type="text" disabled class="input" name="title" value="{{$sys['title']}}"/>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>网站关键字：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" name="keywords" disabled
                                  style="height:80px">{{$sys['keywords']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>网站描述：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" disabled name="desc">{{$sys['desc']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>作者：</label>
                    </div>
                    <div class="field">
                        <textarea class="input" disabled name="author">{{$sys['author']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label">
                        <label>底部信息：</label>
                    </div>
                    <div class="field">
                        <textarea name="footer" disabled class="input"
                                  style="height:120px;">{{$sys['footer']}}</textarea>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <a class="button bg-main icon-check-square-o" href="{{url('admin/system/edit')}}"> 修改</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </body>
@endsection