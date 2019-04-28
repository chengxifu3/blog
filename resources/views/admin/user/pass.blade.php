@extends('admin.layout.layout')
@section('content')
    <body>
    <div class="panel admin-panel">
        <div class="panel-head"><strong><span class="icon-key"></span> 修改会员密码</strong></div>
        <div class="body-content">
            <form method="post" id="form" class="form-x" action="{{url('admin/pass')}}">
                @csrf
                <div class="form-group">
                    <div class="label">
                        <label for="sitename">管理员帐号：</label>
                    </div>
                    <div class="field">
                        <label style="line-height:33px;">
                            {{session('admin_name')}}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="sitename">原始密码：</label>
                    </div>
                    <div class="field">
                        <input type="password" class="input w50" ajaxurl="{{url('admin/checkPass')}}" id="mpass"
                               name="admin_pass" size="50" placeholder="请输入原始密码" datatype="s4-8"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="sitename">新密码：</label>
                    </div>
                    <div class="field">
                        <input type="password" class="input w50" name="newpass" size="50" placeholder="请输入新密码"
                               datatype="s4-10"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="sitename">确认新密码：</label>
                    </div>
                    <div class="field">
                        <input type="password" class="input w50" recheck="newpass" name="renewpass" size="50"
                               placeholder="请再次输入新密码" datatype="s4-10"/>
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
        $('#form').Validform({
            tiptype: 4,
            ajaxPost: true,
            callback: function (res) {
                if (res.status == 'success') {
                    window.parent.location.href = "{{url('admin/logout')}}";
                } else {
                    layer.alert(res.msg);
                }
            }
        });
    </script>
    </body>
@endsection