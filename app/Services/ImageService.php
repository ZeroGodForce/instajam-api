<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Create a new image.
     */
    public function create(array $data): JsonResponse|Image
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $filename = $this->storeImage($data['image']);
        } else {
            return response()->json(['error' => 'Invalid image file'], 500);
        }

        $absoluteFilePath = storage_path('app/public/'.$filename);
        $imageStats = getimagesize($absoluteFilePath);

        return Image::create([
            'user_id' => Auth::id(),
            'filename' => $filename,
            'title' => $data['title'],
            'description' => $data['description'],
            'favourite' => $data['favourite'] ?? false,
            'height' => $imageStats[1] ?? null,
            'width' => $imageStats[0] ?? null,
            'filesize' => (int) filesize($absoluteFilePath) ?? null,
        ]);
    }

    /**
     * Toggle an image as favourite.
     */
    public function toggleFavourite(Image $image, array $data): Image
    {
        if ($image['user_id'] === request()->user()->id) {
            $image->update(['favourite' => (bool) $data['favourite']]);
        }

        return $image;
    }

    /**
     * Store the image and return its filename.
     */
    protected function storeImage(UploadedFile $file): string
    {
        return Storage::disk('public')->putFile('photos', $file);
    }

    /**
     * Return a list of all images for this user
     */
    public function browse($id)
    {
        if (request('filter') === 'favourites') {
            return $this->browseFavourites($id);
        }

        return Image::where('user_id', $id)->get();
    }

    /**
     * Return a list of all favourite images for this user
     */
    public function browseFavourites($id)
    {
        return Image::where([
            ['user_id', $id],
            ['favourite', true],
        ])->get();
    }
}
