@extends('home.layout.layout')
@section('content')
    <article>
        <link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        @include('home.layout.aside')


        <main class="r_box">

            @if(!empty($images))
                <div id="slidr-img" style="display: inline-block">
                    @foreach($images as $image)
                        <img data-slidr="{{$loop->iteration}}" onclick='jump("{{$image['url']}}")'
                             src="/{{$image['image_url']}}"/>
                    @endforeach
                </div>
            @endif
            @if(!empty($articles))
                @foreach($articles as $article)
                    <li><i><a href="{{url('article/detail/'.$article['id'])}}"><img src="{{$article['image_url']}}"></a></i>
                        <h3><a href="{{url('article/detail/'.$article['id'])}}">{{$article['title']}}</a></h3>
                        <p>{{$article['desc']}}</p>
                    </li>
                @endforeach
            @endif
            {{$articles->links()}}


        </main>
    </article>
    <script>
        function jump(url) {
            window.open(url);
        }
    </script>
@endsection
