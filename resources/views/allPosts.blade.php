@extends('baseplate')

@section('content')

<!-- Page Header -->
  <header class="masthead" id="topPicture" style="background-image: url('img/bg-2.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Digital Scribe</h1>
            <span class="subheading">A Blog Following My Life and My Wonderings</span>
          </div>
        </div>
      </div>
    </div>
  </header>

<!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

        @if(isset($pinnedPosts))
        @foreach($pinnedPosts as $post)
        <div class="post-preview">
          <div class="row">
            <div class="col-md-7">
              <a href="/post/{{$post->id}}">
                <h2 class="post-title">
                  {{$post->title}}
                </h2>
              </a>
            </div>
            <div class="col-md-5 tag-area">
              @foreach($tags as $tag)
              @if($tag->post_id == $post->id)
              <button class="btn btn-success float-right btn-tag" style="background-color:#{{$tag->color}}; margin: 3px;">{{$tag->name}}</button>
              
              @endif
              @endforeach
            </div>
          </div>
          <p class="post-meta">Posted by
            <a href="#">{{$post->name}}</a>
            on {{date('F jS Y', strtotime($post->created_at))}}</p>
        </div>
        <hr>
        @endforeach
        @endif
        @foreach($last4 as $post)
        <div class="post-preview">
          <div class="row">
            <div class="col-md-7">
              <a href="/post/{{$post->id}}">
                <h2 class="post-title">
                  {{$post->title}}
                </h2>
              </a>
            </div>
            <div class="col-md-5 tag-area">
              @foreach($tags as $tag)
              @if($tag->post_id == $post->id)
              <button class="btn btn-success float-right" style="background-color:#{{$tag->color}}; margin: 3px;">{{$tag->name}}</button>
              
              @endif
              @endforeach
            </div>
          </div>
          <p class="post-meta">Posted by
            <a href="#">{{$post->name}}</a>
            on {{date('F jS Y', strtotime($post->created_at))}}</p>
        </div>
        <hr>
        @endforeach
        
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-left" href="/">Home &larr;</a>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
<script>

</script>


@endsection