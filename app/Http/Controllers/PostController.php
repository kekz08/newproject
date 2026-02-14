<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user:id,username')
            ->withCount(['reactions', 'comments'])
            ->where('audience', 'public')
            ->latest()
            ->paginate(10);

        // Add liked_by_user flag and likes_count alias for frontend
        $posts->getCollection()->transform(function ($post) {
            $post->liked_by_user = $post->reactions()->where('user_id', auth()->id())->exists();
            $post->likes_count = $post->reactions_count;
            return $post;
        });

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|string', // Base64
            'audience' => 'required|string|in:public,friends,private',
        ]);

        $imagePath = null;
        if ($request->filled('image')) {
            $imagePath = $this->handleBase64Image($request->input('image'));
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'text' => $request->input('text'),
            'image' => $imagePath,
            'audience' => $request->input('audience'),
        ]);

        return response()->json([
            'message' => 'Post created successfully!',
            'post' => $post->load('user:id,username'),
        ]);
    }

    protected function handleBase64Image($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $match)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $extension = strtolower($match[1]);

            if ($extension === 'webp') {
                $extension = 'png';
            }

            if (!in_array($extension, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg'])) {
                throw new \Exception('Invalid image type.');
            }

            $data = base64_decode($data);
            if ($data === false) {
                throw new \Exception('Base64 decode failed.');
            }

            $userId = auth()->id();
            $directory = "uploads/{$userId}/post";
            Storage::disk('local')->makeDirectory($directory);

            $fileName = Str::random(40) . ".{$extension}";
            $path = "{$directory}/{$fileName}";

            Storage::disk('local')->put($path, $data);

            return $fileName;
        }

        return null;
    }
}
