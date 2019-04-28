@extends('home.layout.layout')
@section('content')
    <style>
        .page-item {
            display: inline-block;
        }
    </style>
    <article>
        @include('home.layout.aside')
        <main class="r_box">
            @if(!empty($articles))
                @foreach($articles as $article)
                    <li><i><a href="{{url('article/detail/'.$article['id'])}}"><img
                                        src="/{{$article['image_url']}}"></a></i>
                        <h3><a href="{{url('article/detail/'.$article['id'])}}">{{$article['title']}}</a></h3>
                        <p>{{$article['desc']}}</p>
                    </li>
                @endforeach
            @else
                没有你要搜索的关键词
            @endif
        </main>
    </article>
@endsection
