<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct(protected ImageService $imageService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = $this->imageService->browse(request()->user()->id);

        return ImageResource::collection($images);
    }

    /**
     * Store a newly created Image in storage.
     */
    public function store(StoreImageRequest $request): ImageResource
    {
        $image = $this->imageService->create($request->all());

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     */
    public function show($filename)
    {
        $image = Image::where([
            'filename' => $filename,
            'user_id' => auth()->id(),
        ]);

        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(Image $image)
    {
        //
    }

    /**
     * Set the specified image's favourite status and then return a complete list of all image'.
     */
    public function favourite(Request $request, Image $image)
    {
        $this->imageService->toggleFavourite($image, $request->all());

        return ImageResource::collection($this->imageService->browse($request->user()->id));
    }
}
