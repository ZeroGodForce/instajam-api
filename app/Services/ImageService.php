<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    /**
     * Create a new image.
     * @todo HANDLE IMAGE UPLOAD FAILURE
     * @param array $data
     * @return Image
     */
    public function create(array $data): Image
    {
        if(isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $filename = $this->storeImage($data['image']);
        } else {
            abort(500);
        }

        return Image::create([
            'user_id' => Auth::id(),
            'filename' => $filename,
            'title' => $data['title'],
            'description' => $data['description'],
            'favourite' => $data['favourite'] ?? false,
        ]);
    }

    /**
     * Update an existing image.
     *
     * @param Image $image
     * @param array $data
     * @return Image
     */
    public function update(Image $image, array $data): Image
    {
        $update = [
            'title' => $data['title'],
            'description' => $data['description'],
            'favourite' => $data['favourite'],
        ];

        $image->update($update);

        return $image;
    }

    /**
     * Soft delete an image.
     *
     * @param Image $image
     * @return void
     */
    public function delete(Image $image): void
    {
        $image->delete();
    }

    /**
     * Force delete an image.
     *
     * @param Image $image
     * @return void
     */
    public function forceDelete(Image $image): void
    {
        $image->forceDelete();
    }

    /**
     * Toggle an image as favourite.
     *
     * @param Image $image
     * @param array $data
     * @return Image
     */
    public function toggleFavourite(Image $image, array $data): Image
    {
        $image->update(['favourite' => (bool) $data['favourite']]);

        return $image;
    }

    /**
     * Store the image and return its filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function storeImage(UploadedFile $file): string
    {
        return Storage::disk('public')->putFile('photos', $file);
    }
}
