<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Get post posts, paginated
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) {
        $user = Auth::user() ?? null;
        $posts = Post::orderBy('id', 'DESC')->where(function($qry) use ($request) {
                    if($request->search) {
                        /* IF full text index defined */
                        //$qry->whereRaw(
                        //    sprintf('MATCH (title,body) AGAINST ("%s" IN NATURAL LANGUAGE MODE)', $request->search)
                        //);

                        //Search title of blog post .. starting with given search phrase
                        //$qry->where('title','like', $request->search.'%');

                        //Search in title of blog post .. search phrase any where in text
                        $qry->where('title','like', '%'.$request->search.'%');

                    }
                })->paginate(10);
        return view('blog.home', compact('user', 'posts'));
    }

    /**
     * View single post
     *
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function view(Post $post, Request $request) {
        $user = Auth::user() ?? null;
        return view('blog.view', compact('user', 'post'));
    }

    /**
     * Add new post form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function add() {
        $user = Auth::user() ?? null;
        return view('blog.add', compact('user'));
    }

    /**
     * Save postback data for new post form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function save(Request $request) {
        $user = Auth::user() ?? null;
        if($user) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required',
                'post_image' => 'image|mimes:jpg,png,jpeg|max:2048',
            ]);
            $post_image = '';
            if($request->hasFile('post_image')) {
                $file = $request->file('post_image');
                //$file_name = $file->getClientOriginalName();
                $post_image = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                $base_path = env('POST_IMAGES_PATH');
                if(!$file->storePubliclyAs($base_path, $post_image, ['disk' => 'public'])) {
                    back()->withErrors('Unable to upload image file. Please try again.');
                } else {
                    //generate thumbnail overwriting same file
                    $base_path = storage_path('app/public/') . env('POST_IMAGES_PATH');
                    $file_path = $base_path . $post_image;
                    $img = Image::make($file_path);
                    $img->resize(250, 250, function ($constraint) {
                        //$constraint->aspectRatio();
                    })->save($file_path);
                }
            }
            Post::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'body' => $validated['body'],
                'post_image' => $post_image,
            ]);
            return redirect()->route('my-posts')->with(['success' => 'New post was added successfully.']);
        }

        return response('Unauthorized', 401);
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Post $post, Request $request) {
        $user = Auth::user() ?? null;
        if($user && $user->id == $post->user_id) {
            return view('blog.edit', compact('user', 'post'));
        }

        return response('Unauthorized', 401);
    }

    public function update(Post $post, Request $request) {
        $user = Auth::user() ?? null;
        if($user && $user->id == $post->user_id) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required',
                'post_image' => 'image|mimes:jpg,png,jpeg|max:2048',
            ]);

            $post_image = '';
            if($request->hasFile('post_image')) {
                $file = $request->file('post_image');
                $post_image = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                $image_path = env('POST_IMAGES_PATH');
                if(!$file->storePubliclyAs($image_path, $post_image, ['disk' => 'public'])) {
                    return back()->withErrors('Unable to upload image file. Please try again');
                } else {
                    //generate thumbnail overwriting same file
                    $image_path = storage_path('app/public/') . env('POST_IMAGES_PATH');
                    $file_path = $image_path . $post_image;
                    $img = Image::make($file_path);
                    $img->resize(250, 250, function ($constraint) {
                        //$constraint->aspectRatio();
                    })->save($file_path);
                    //-------------------------------------------------------------------------
                    //remove the previous / existing file if any
                    if(!empty($post->post_image)) {
                        $image_path = env('POST_IMAGES_PATH');
                        Storage::disk('public')->delete($image_path . $post->post_image);
                    }
                }
            } else {
                $post_image = $post->post_image; //maintain existing file as it is..
            }

            $post->update([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'post_image' => $post_image,

            ]);
            return redirect()->route('edit-post', ['post' => $post->id])->with(['success' => 'Post was updated successfully.']);
        }

        return response('Unauthorized', 401);
    }

    /**
     * Delete a blog post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function delete(Post $post) {
        $user = Auth::user() ?? null;
        if($user && $user->id == $post->user_id) {
            //remove the previous / existing file if any
            if(!empty($post->post_image)) {
                $image_path = env('POST_IMAGES_PATH');
                Storage::disk('public')->delete($image_path . $post->post_image);
            }
            $post->delete();
            return redirect()->route('my-posts')->with(['success' => 'Post was removed successfully.']);
        }

        return response('Unauthorized', 401);
    }

    /**
     * Authenticated user's post list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\RedirectResponse
     */
    public function my_posts() {
        $user = Auth::user() ?? null;
        if($user) {
            $posts = Post::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
            return view('blog.my_posts', compact('user', 'posts'));
        }

        return redirect()->route('login')->with(['error' => 'Please login to continue...']);

    }

    /**
     * Add a new comment on a blog post by authenticated user
     *
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add_comment(Post $post, Request $request) {
        $user = Auth::user() ?? null;
        if(!$user) {
            return redirect()->route('login')->with(['error' => 'You must be logged in before writing a comment']);
        }
        $validated = $request->validate([
            'commentText' => 'required|string',
        ]);
        $rtn = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => trim($validated['commentText']),
        ]);
        if(!$rtn) {
            return back()->with(['error' => 'Unable to save your comment, please try again.']);
        }
        return back()->with(['success' => 'Thanks, your comment saved successfully.']);
    }

    /**
     * Delete a comment by original authenticated user
     *
     * @param Post $post
     * @param Comment $comment
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete_comment(Post $post, Comment $comment, Request $request) {
        $user = Auth::user() ?? null;
        if(!$user) {
            return redirect()->route('login')->with(['error' => 'You must be logged in before writing a comment']);
        }
        if($post->id === $comment->post_id && $user->id === $comment->user_id) {
            $comment->delete();
            return redirect()
                    ->route('view-post', ['post' => $post->id, 'slug' => Str::slug($post->title)])
                    ->with(['success' => 'Your comment was removed.']);
        }

        return response('Unauthorized', 401);
    }
}
