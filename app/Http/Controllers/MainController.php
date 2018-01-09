<?php

namespace App\Http\Controllers;
use App\post;
use DB;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class MainController extends Controller
{
    public function index()
    { 

      $totalposts=DB::table('posts')
        ->selectraw('count(id) as totalposts')
        ->get();
        $totalposts = $totalposts[0]->totalposts;

      if($month = request('month') and $year = request('year')){
            // dd('dd');
            $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes', function ($join) {
              $join->on('posts.id', '=', 'likes.post_id')->where('likes.user_id', '=',Auth::id());
            })
            ->select('posts.*', 'users.name', 'users.designation','users.email','users.profilepic', 'likes.likestatus')
            ->whereRaw("monthname(posts.created_at) = '$month'")
            ->whereYear('posts.created_at', $year)
            ->orderByRaw('posts.created_at DESC')
            ->get();

        }
        else{

          if(isset($_GET['page']))
          {
            $postsPerPage = 5;
            $startPost = ($_GET['page'] - 1) * $postsPerPage;
            $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes', function ($join) {
              $join->on('posts.id', '=', 'likes.post_id')->where('likes.user_id', '=',Auth::id());
            })
            ->select('posts.*', 'users.name', 'users.designation','users.email','users.profilepic', 'likes.likestatus')
            ->orderByRaw('posts.created_at DESC')
            ->offset($startPost)
            ->limit(5)
            ->get();
            }
            else{
              $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('likes', function ($join) {
              $join->on('posts.id', '=', 'likes.post_id')->where('likes.user_id', '=',Auth::id());
            })
            ->select('posts.*', 'users.name', 'users.designation','users.email','users.profilepic', 'likes.likestatus')
            ->orderByRaw('posts.created_at DESC')
            ->limit(5)
            ->get();
            }
        }
        // dd($posts);

            // $posts->whereMonth('created_at', 12);
        $comment_count = DB::table('posts')
        ->join('comments', 'posts.id', '=', 'comments.post_id')
        ->selectraw('posts.id, count(comments.id) as cid')
        ->groupBy('posts.id')
        ->get();
        $comments = DB::table('posts')
        ->join('comments', 'posts.id', '=', 'comments.post_id')
        ->join('users', 'users.id', '=', 'comments.user_id')
        ->selectraw('posts.id, users.name, users.profilepic, comments.id as comment_id ,users.id as user_id, comments.body,comments.edited, comments.created_at')
        ->orderByRaw('comments.created_at DESC')
        ->get();
        return view('layouts.index', compact('posts', 'comment_count', 'totalposts', 'comments'));
    }
    public function show($postid)
    { 
      if( Auth::check()){
           $posts = DB::table('posts')
           ->join('users', 'users.id', '=', 'posts.user_id')
           ->leftJoin('likes', function ($join) {
              $join->on('posts.id', '=', 'likes.post_id')->where('likes.user_id', '=',Auth::id());
            })
           ->select('posts.*','users.name', 'users.designation','users.email','users.profilepic', 'likes.likestatus')
           ->get();
           $comment_count = DB::table('posts')
           ->join('comments', 'posts.id', '=', 'comments.post_id')
           ->leftJoin('likes', 'posts.id', '=', 'likes.post_id', 'and', 'users.id', '=', 'likes.user')
           ->selectraw('posts.id, count(comments.id) as cid')
           ->groupBy('posts.id')
           ->get();    

           $comments = DB::table('posts')
           ->join('comments', 'posts.id', '=', 'comments.post_id')
           ->join('users', 'users.id', '=', 'comments.user_id')
           ->selectraw('posts.id, users.name, users.profilepic, users.id as user_id,comments.id as comment_id,comments.edited,  comments.body, comments.created_at')
           ->orderByRaw('comments.created_at DESC')
           ->get();
           return view('posts.show', compact('posts', 'comment_count', 'postid', 'comments'));

       }
       else{
        return redirect('login');
    }


}


}
