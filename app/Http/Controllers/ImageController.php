<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Services\ImageService;

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
        return ImageResource::collection(Image::where('user_id', request()->user()->id)->get());
    }

    /**
     * Store a newly created Image in storage.
     *
     * @param StoreImageRequest $request
     * @return ImageResource
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
        //
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
     * Remove the specified resource from storage.
     */
    public function favourite(UpdateImageRequest $request, Image $image)
    {
        $this->imageService->toggleFavourite($image, $request->all());
    }
}
