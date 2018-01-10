
@include ('layouts.head')
@include ('layouts.nav2')
@include ('layouts.header')

<div class="container ">
  <div class="row">

    <div class="col-lg-9 col-md-9 col-sm-9 blog-main">
      <div class="post-preview postdiv2">


        @foreach ($posts as $post)
        @if($post->id == $postid)
        <div class='row'>
          <div class="col-md-1 " data-toggle="modal" data-target="#postModal{{ $post->user_id }}">
            <img @if(!empty($post->profilepic)) src="{{ $post->profilepic }}" @else src="/img/profilepic.jpg" @endif alt="" class='comment-imground class6' width="45" height="45">
          </div>
          <div class='col-md-8 class5'>
            <div class='row'> 
              <a class='post-title' href="/post/{{ $post->id }}">{{ $post->title}}</a>
            </div>
            <div class='row paddingtop' >
              <p class='pull-left'>Published by 
                <a href="/user/{{ $post->user_id }}">{{ $post->name }} </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </p>
              <span class="fa fa-heart-o" ></span><span class="likesbutton{{ $post->id }}">  {{$post->likes}}</span>
              &nbsp;
            </div>
          </div>
          <div class="col-md-3">
          </div>
        </div>
        <div class="modal fade" id="postModal{{ $post->user_id }}" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

              <div class='row'>
                <div class="modal-body">
                  <div class='col-md-6'>

                    <img @if(!empty($post->profilepic)) src="{{ $post->profilepic }}" @else src="/img/profilepic.jpg" @endif alt="" width="200" height="200">
                  </div>
                  <div class='col-md-6'>
                    <br>
                    <h3><a href="/user/{{ $post->user_id }}">{{ $post->name }}</a></h3>
                    <p>{{ $post->email }}</p>
                    <p >{{ $post->designation }}</p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <div class='row padallover'>
          <div class="post-body" style="margin-left: -18px;" >
            {{-- {!!  $post->body !!} --}}
            {!!  $post->body !!}

          </div>
        </div>


        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-11" style="margin-left: -18px;">
            <p class="post-meta">Published on
              {{ $post->created_at }} 
              @if(!empty($post->edited_at)) <strong> edited on </strong>{{ $post->edited_at }} @endif

              <a data-id={{$post->id}} class="commentbtn pull-right">
                
                @foreach($comment_count as $cm)
                @if($cm->id == $post->id)
                <span class="fa fa-comment-o"></span>Comments ({{$cm->cid}})
                @endif
                @endforeach
              </a>

          {{-- <span class="likesbutton pull-right">
            <span class="fa fa-heart-o"></span>{{$post->likes}}</span>  --}}
          </p>
        </div>
      </div>
      @include('comments.show_nologin')
      @endif
      @endforeach
    </div>

  </div>

  @include('layouts.sidebar')
</div>
</div>
<br>
<br>
@include ('layouts.footer')