<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use JWTAuth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::with('comments', 'ratings')->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'location' => 'required',
            'charges' => 'required',
            'status' => 'required',
            'description' => 'required',
            'image1' => 'required|mimes:jpeg,png,jpg|max:2048',
            // 'image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'image3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'image4' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // $image1 = $request->image1;
        // $image2 = $request->image2;
        // $image3 = $request->image3;
        // $image4 = $request->image4;

        // $path_image1 = $image1->store('attachements_images');
        // $path_image2 = $image2->store('attachements_images');
        // $path_image3 = $image3->store('attachements_images');
        // $path_image4 = $image4->store('attachements_images');

        $image1 = $request->file('image1');
        $name_image1 = $this->handleImageUploads($image1);

        $user = JWTAuth::user();
        $post1 = Post::create([
            'user_id' => $request->user()->id,
            'title' => ucfirst($request->title),
            'location' => ucfirst($request->location),
            'charges' => $request->charges,
            'status' => $request->status,
            'image1' => $name_image1,
            // 'image2' => $path_image2,
            // 'image3' => $path_image3,
            // 'image4' => $path_image4,
            'description' => ucfirst($request->description),
        ]);
        $success = true;
        $message = 'Successfully created a post';
        $post = new PostResource($post1);

        return response()->json(compact('post', 'success', 'message'), 201);
    }

    //Function to handle image uploads
    public function handleImageUploads($image)
    {
        $image_name = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnail');

        $resize_image = Image::make($image->getRealPath());

        $resize_image->resize(700, 700, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image_name);

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $image_name);

        return $image_name;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return new PostResource($post);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Could not find a post',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = JWTAuth::user();
        $post = Post::find($id);
        // check if currently authenticated user is the owner of the book
        if ($post) {
            if ($user->id !== $post->user_id) {
                return response()->json(['error' => 'You can only edit your own books.'], 403);
            } else {
                $post->title = ucfirst($request->title);
                $post->location = ucfirst($request->location);
                $post->charges = $request->charges;
                $post->status = $request->status;
                $post->description = ucfirst($request->description);
                $post->save();

                return response()->json([
                    'post'=> new PostResource($post),
                    'success' => true,
                    'message' => 'Successfully Updated a post',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Could not find a post',
            ], 404);
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
        $post = Post::find( $id);
        if ( $post ) {
            $post->delete();
            return response()->json( [
                'success' => true,
                'message' => 'Successfully deleted your post'
            ], 200 );
        } else {
            return response()->json( [
                'success' => false,
                'message' => 'Could not find a post'
            ], 404 );
        }
    }
}
