<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileImageController extends Controller
{
    /**
     * Handle the Base64 image upload.
     */
    public function store(Request $request, $type)
    {
        if (!in_array($type, ['avatar', 'cover', 'post'])) {
            return response()->json(['message' => 'Invalid upload type.'], 422);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'image' => 'required|string', // Base64 string
        ], [
            'image.required' => 'The image field is missing.',
            'image.string' => 'The image must be a valid Base64 string.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $base64Image = $request->input('image');

        // Extract the mime type and the base64 data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $match)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $extension = strtolower($match[1]); // jpg, png, gif

            if ($extension === 'webp') {
                $extension = 'png'; // Forced extension
            }

            if (!in_array($extension, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg'])) {
                return response()->json(['message' => 'Invalid image type: ' . $extension], 422);
            }

            $data = base64_decode($data);

            if ($data === false) {
                return response()->json(['message' => 'base64_decode failed.'], 422);
            }
        } else {
            return response()->json(['message' => 'Did not match data URI with image data.'], 422);
        }

        $userId = auth()->id();
        $user = auth()->user();
        $directory = "uploads/{$userId}/{$type}";

        Storage::disk('local')->makeDirectory($directory);

        $fileName = ($type === 'post')
            ? Str::random(40) . ".{$extension}"
            : "{$type}_" . time() . ".{$extension}";

        $path = "{$directory}/{$fileName}";

        // Store the file in storage/app/uploads/{user_id}/{type}
        Storage::disk('local')->put($path, $data);

        // Update active image in users table
        if ($type === 'avatar') {
            $user->update(['active_avatar' => $fileName]);
        } elseif ($type === 'cover') {
            $user->update(['active_cover' => $fileName]);
        }

        return response()->json([
            'message' => ucfirst($type) . ' updated successfully.',
            'url' => route('profile.image.show', ['type' => $type, 'userId' => $userId]) . '?t=' . time()
        ]);
    }

    /**
     * Serve the user's image.
     */
    public function show(Request $request, $type, $userId, $fileName = null)
    {
        if (!in_array($type, ['avatar', 'cover', 'post'])) {
            abort(404);
        }

        $user = \App\Models\User::find($userId);
        if (!$user) {
            abort(404);
        }

        $directory = "uploads/{$userId}/{$type}";

        // Privacy check
        $isOwner = auth()->check() && auth()->id() == $userId;

        if ($type !== 'avatar' && !$isOwner) {
            // Check if it's a post image. Post images are public if the post is public.
            if ($type === 'post') {
                 // For now, we allow public access to all post images.
                 // Ideally we check the audience of the post this image belongs to.
            } else {
                 return abort(403, 'This image is private.');
            }
        }

        // If a specific filename is provided, use it
        if ($fileName) {
            $imageFile = "{$directory}/{$fileName}";
            if (Storage::disk('local')->exists($imageFile)) {
                $path = Storage::disk('local')->path($imageFile);
                return response()->file($path, $this->getCacheHeaders());
            }
        }

        // Otherwise, fall back to active image logic
        $activeFileName = null;
        if ($type === 'avatar') {
            $activeFileName = $user->active_avatar;
        } elseif ($type === 'cover') {
            $activeFileName = $user->active_cover;
        }

        if ($activeFileName) {
            $imageFile = "{$directory}/{$activeFileName}";
            if (Storage::disk('local')->exists($imageFile)) {
                $path = Storage::disk('local')->path($imageFile);
                return response()->file($path, $this->getCacheHeaders());
            }
        }

        // If specific active file not found or not set, try to find any file in directory for backward compatibility
        $files = Storage::disk('local')->files($directory);
        if (!empty($files)) {
            $imageFile = $files[0];
            if (Storage::disk('local')->exists($imageFile)) {
                $path = Storage::disk('local')->path($imageFile);
                return response()->file($path, $this->getCacheHeaders());
            }
        }

        // Return defaults
        if ($type === 'avatar') {
            return response()->file(public_path('images/default-avatar.png'), $this->getCacheHeaders());
        }

        if ($type === 'cover') {
            return response()->file(public_path('images/default-cover.png'), $this->getCacheHeaders());
        }

        abort(404);
    }

    protected function getCacheHeaders()
    {
        return [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];
    }
}
