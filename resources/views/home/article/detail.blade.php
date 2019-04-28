@extends('home.layout.layout')
@section('content')
    <article>
        @include('home.layout.aside')
        <main>
            <div class="infosbox">
                <div class="newsview">
                    <h3 class="news_title">{{$article['title']}}</h3>
                    <div class="bloginfo">
                        <ul>
                            <li class="author">作者：<a href="/">{{$article['author']}}</a></li>

                            <li class="timer">时间：{{date('Y-m-d',$article['updated_at'])}}</li>
                            <li class="view">{{$article['views']}}人已阅读</li>
                        </ul>
                    </div>

                    <div class="news_about"><strong>简介</strong>

                        {{$article['desc']}}
                    </div>
                    <div class="news_con">


                        {!!  $article['content']!!}

                    </div>
                    <div class="share">
                        <p class="diggit"><a id="diggit" href="JavaScript:;"> 很赞哦！ </a>(<b
                                    id="diggnum">{{$article['diggits']}}</b>)</p>
                    </div>
                    <div class="nextinfo">
                        <p>上一篇：@if(!empty($preArt))<a
                                    href="{{url('article/detail/'.$preArt->id)}}">{{$preArt->title}}</a>@endif</p>
                        <p>下一篇：@if(!empty($nextArt))<a
                                    href="{{url('article/detail/'.$nextArt->id)}}">{{$nextArt->title}}</a>@endif</p>
                    </div>
                    <div class="news_pl">
                        <h2>文章评论</h2>
                        <div class="gbko">
                            <div class="fb">
                                @if(!empty($comments))
                                    @foreach($comments as $comment)
                                        <ul>
                                            <p class="fbtime">
                                                <span>{{date('Y-m-d',$comment->created_at)}}</span>{{$comment->username}}
                                            </p>
                                            <p class="fbinfo">{!! $comment->content !!}</p>
                                        </ul>
                                    @endforeach
                                @endif
                            </div>


                            <form id="form" action="{{url('article/comment')}}" method="post">
                                @csrf
                                <div id="plpost">

                                    <p class="saying"><span><a href="#">@if($comment_num)共有{{$comment_num}}条评论@endif</a></span>来说两句吧...
                                    </p>

                                    <p class="yzm"><span>验证码:</span>
                                        <input name="code" type="text" datatype="s4-4" class="inputText" size="16">
                                        <img src="{{captcha_src()}}" alt="" class="passcode"
                                             style="height:43px;width:200px;cursor:pointer;"
                                             onclick="this.src=this.src+'?'">
                                    </p>

                                    <textarea name="content" datatype="s4-255" rows="6" id="saytext"></textarea>
                                    <input type="submit" value="提交">
                                    <input type="hidden" name="id" value="{{$article['id']}}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </main>
    </article>
    <script>
        $("#diggit").click(function () {
            $.get("{{url('artilce/diggit/'.$article['id'])}}", null, function (res) {
                if (res.status == 'nologin') {
                    layer.confirm(res.msg, function () {
                        location.href = "{{url('login')}}";
                    })
                }
                if (res.status == 'success') {
                    layer.alert('点赞成功');
                    $("#diggnum").html(res.num);
                }
                if (res.status == 'fail') {
                    layer.alert(res.msg);
                }
            }, 'json');
        });
        $("#form").Validform({
            tiptype: 4,
            ajaxPost: true,
            callback: function (res) {
                if (res.status == 'nologin') {
                    layer.confirm(res.msg, function () {
                        location.href = "{{url('login')}}";
                    })
                }
                if (res.status == 'fail') {
                    layer.alert(res.msg);
                }
                if (res.status == 'success') {
                    layer.alert(res.msg);
                    location.href = "{{url('article/detail/'.$article['id'])}}";
                }
            }
        });
    </script>
@endsection
