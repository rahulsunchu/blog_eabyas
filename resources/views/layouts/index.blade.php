@guest
@include('auth.login') 
@else
@include ('layouts.head')
@include ('layouts.nav2')
@include ('layouts.header')
<div class="container ">
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 blog-main">
      <div class="post-preview">
        @foreach ($posts as $post )
        <div class='postdiv'>
          @include('posts.viewpost')
        </div> 
        @endforeach
      </div>
<?php
      $postsPerPage = 5;
      $totalPages = ceil($totalposts / $postsPerPage);
?>

@if($totalPages > 1)

<?php

      
// Check that the page number is set.
      if(!isset($_GET['page'])){
        $_GET['page'] = 0;
      }else{
    // Convert the page number to an integer
        $_GET['page'] = (int)$_GET['page'];
      }


// If the page number is less than 1, make it 1.
      if($_GET['page'] < 1){
        $_GET['page'] = 1;
    // Check that the page is below the last page
      }else if($_GET['page'] > $totalPages){
        $_GET['page'] = $totalPages;
      }
      ?>

      <div class="centerpagination">
        <div class="pagination pull-right">
          <?php 
          $pageless = $_GET['page'] - 1;
          $pagemore = $_GET['page'] + 1;
          if(!isset($_GET['page']) or $_GET['page'] !== 1){
            echo '<a href="?page=' .$pageless. '">&laquo;</a>'; 
          }
          foreach(range(1, $totalPages) as $page){
    // Check if we're on the current page in the loop
            if($page == $_GET['page']){
              echo '<a class="btn btn-primary">' . $page . '</a>';
            }else if($page == 1 || $page == $totalPages || ($page >= $_GET['page'] - 2 && $page <= $_GET['page'] + 2)){
              echo '<a href="?page=' . $page . '">' . $page . '</a>';
            }
          }
          if( $_GET['page'] != $totalPages){
          echo '<a href="?page=' .$pagemore. '">&raquo;</a>';
          }
          ?>
        </div>
      </div>

      @endif
    </div>
    @include('layouts.sidebar')
  </div>
</div>
<br>
<br>

@include ('layouts.footer')
@endguest


