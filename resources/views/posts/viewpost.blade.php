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
            </div>
          </div>
          <div class="col-md-3">
            @if($post->user_id == Auth::user()->id)
            <a href="/post/edit/{{ $post->id }}" class="pull-right" data-toggle="tooltip" data-placement="bottom" title="edit post"> <span class="fa fa-edit fa-edit2"></span></a>
            <a href="/post/delete/{{ $post->id }}" class="pull-right" id="deletepost" data-toggle="confirmation" data-title="Confirm delete?"> <span class="fa fa-trash fa-trash2"  data-toggle="tooltip" data-placement="bottom" title="delete post"></span></a>
            @endif
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

        
        <div class='row'>
          <div class="col-md-1"></div>
          <div class="col-md-11">
            <div class="post-subtitle post-subtitle2 " style="margin-left: -18px;" >
              <?php 
              $htmldata = strip_tags($post->body,"<p>");
              ?>
              {{-- @if(strlen($post->body) > 400) --}}
               {!! $htmldata  !!}
              {{-- @else --}}
               {{-- {!! $htmldata !!} --}}
              {{-- {!!  str_replace("tinymce/source/","/tinymce/source/",$post->body) !!} --}}
              {{-- @endif --}}
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-11" style="margin-left: -18px;">
            <p class="post-meta">Published on
              {{ $post->created_at }} 
              {{-- @if(!empty($post->edited_at)) <strong> edited on </strong>{{ $post->edited_at }} @endif --}}

              <a data-id={{$post->id}} class="commentbtn pull-right">
                <span class="fa fa-comment-o"></span>Comments 
                @foreach($comment_count as $cm)
                @if($cm->id == $post->id)
                ({{$cm->cid}})
                @endif
                @endforeach
              </a>
              &nbsp;
              <a  data-post={{$post->id}} data-user={{Auth::id()}} class="likebtn pull-right likebtn{{$post->id}}"  @if($post->likestatus) style="display: none;" @endif>
                <span class="fa fa-thumbs-o-up">Like</span>


              </a>
              <a  data-post={{$post->id}} data-user={{Auth::id()}} class="unlikebtn pull-right unlikebtn{{$post->id}}" @if(!$post->likestatus) style="display: none;" @endif>
                <span class="fa fa-thumbs-o-up">Liked</span>
              </a> 


          {{-- <span class="likesbutton pull-right">
            <span class="fa fa-heart-o"></span>{{$post->likes}}</span>  --}}
          </p>
        </div>
      </div>
      @include('comments.show')
      <hr>
