<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use App\Http\Resources\PersonalInfoResource;
use App\Http\Requests\PersonalInfoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Attachment;
use App\Models\Image;

class PersonalInfoController extends Controller
{
    public function showStock() {
        $personalInfo = PersonalInfo::where('user_id', 1)->get();
        return PersonalInfoResource::collection($personalInfo);
    }


    public function show() {
        $user = Auth::user();
        $personalInfo = PersonalInfo::where('user_id', $user->id)->get();
        return PersonalInfoResource::collection($personalInfo);
    }

    public function store(PersonalInfoRequest $request) {
        $user = Auth::user();

        $personalInfo = PersonalInfo::where('user_id', $user->id)->first();
        if ($personalInfo) {
            $personalInfo->update($request->all());
            return new PersonalInfoResource($personalInfo);
        }
        // ja nav vecā ieraksta, tad izveido jaunu
        $personalInfo = PersonalInfo::create($request->all() + ['user_id' => $user->id]);
        return new PersonalInfoResource($personalInfo);
    }

    public function addImages(Request $request)
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
    $user = Auth::user();
    $personalInfo = PersonalInfo::where('id', $user->id)->first();
    // if personal info doesn't have an attachment_id create a new one
    if (!$personalInfo->attachment) {
        $personalInfo->attachment()->create();  
        $personalInfo->load('attachment');
    } 

    foreach ($request->file('images') as $image) {
        // Save the image with the attachment ID
        $path = $image->store('images/personalInfo', 'public');
        $image = new Image();
        $image->url = Storage::url($path);
        $image->attachment_id = $personalInfo->attachment->id;
        $image->save();

        $uploadedImages[] = $image; // Add to the result list
    }

    return response()->json([
        'message' => 'Images uploaded successfully.',
        'images' => $uploadedImages,
    ]);
}


    public function removeImage(int $id, int $image_id){

        $personalInfo = PersonalInfo::where('id', $id)->first();

        $image = $personalInfo->attachment->images()->where('id', $image_id)->first();
        if ($image) {
            $oldImagePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($oldImagePath);
            $image->delete();
        }
        
        return response()->json(true, 204);; // No content
    }

}
