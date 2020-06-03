<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Post;


class PostsController extends Controller
{
    /**
    * @var array
    */
    protected $rules =
    [
        'title' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
        //'content' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];


    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();

        return view('posts.index', ['posts' => $posts]);
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content_post;
            // Handle File Upload
            if($request->hasFile('cover_image')){
                // Get filename with the extension
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            } else {
                $fileNameToStore = 'default.png';
            }
            $post->cover_image=$fileNameToStore;
            $post->save();
            return response()->json($post);
        }

    }


    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post.show', ['post' => $post]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json($post);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json($post);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $post = Post::findOrFail($id);
        $post->is_published = !$post->is_published;
        $post->save();

        return response()->json($post);
    }
}