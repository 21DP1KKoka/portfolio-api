<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StackInfo;
use App\Http\Resources\StackInfoResource;
use App\Http\Requests\StackInfoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Attachment;
use App\Models\Image;

class StackInfoController extends Controller
{
    public function showStock() {
        $stacklInfo = StackInfo::where('user_id', 1)->get();
        return  StackInfoResource::collection($stacklInfo);
    }


    public function show() {
        $user = Auth::user();
        $stackInfos = StackInfo::where('user_id', $user->id)->get();
        return StackInfoResource::collection($stackInfos);
    }


    public function store(StackInfoRequest $request) {
        $user = Auth::user();

        $stacklInfo = StackInfo::create($request->all() + ['user_id' => $user->id]);
        return new StackInfoResource($stacklInfo);
    }


    public function update(StackInfoRequest $request, int $id) {
        $user = Auth::user();

        $stacklInfo = StackInfo::find($id);
        $stacklInfo->update($request->all());
        return new StackInfoResource($stacklInfo);  
    }


    public function delete(int $id) {
        $stacklInfo = StackInfo::where('id', $id)->first();
        $stacklInfo->delete();
        return response()->json(null, 204);
    }

    
    public function addImages(Request $request, int $id)
    {
        // pārbauda bildes vai atbilst un vai ir vismaz 1
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:4096', 
            'images' => 'required|array|min:1',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity
        }
    
        $uploadedImages = [];
        $stacklInfo = StackInfo::where('id', $id)->first();
        // if personal info doesn't have an attachment_id create a new one
        if (!$stacklInfo->attachment) {
            $stacklInfo->attachment()->create();  
            $stacklInfo->load('attachment');
        } 
    
        foreach ($request->file('images') as $image) {
            // Save the image with the attachment ID
            $path = $image->store('images/stacklInfo', 'public');
            $image = new Image();
            $image->url = Storage::url($path);
            $image->attachment_id = $stacklInfo->attachment->id;
            $image->save();
    
            $uploadedImages[] = $image; // Add to the result list
        }
    
        return response()->json([
            'message' => 'Images uploaded successfully.',
            'images' => $uploadedImages,
        ]);
    }
    
    
        public function removeImage(int $id, int $image_id){
    
            $stacklInfo = StackInfo::where('id', $id)->first();
    
            $image = $stacklInfo->attachment->images()->where('id', $image_id)->first();
            if ($image) {
                $oldImagePath = str_replace('/storage/', '', $image->url);
                Storage::disk('public')->delete($oldImagePath);
                $image->delete();
            }
            
            return response()->json(true, 204);; // No content
        }
}
