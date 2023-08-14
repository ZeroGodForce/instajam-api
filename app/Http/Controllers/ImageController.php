<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
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
        //
    }

    /**
     * Store a newly created Image in storage.
     *
     * @param StoreImageRequest $request
     * @return Image
     * @todo RETURN DATA AS API RESOURCE
     */
    public function store(StoreImageRequest $request)
    {
        return $this->imageService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
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