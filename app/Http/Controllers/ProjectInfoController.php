<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectInfo;
use App\Http\Resources\ProjectInfoResource;
use App\Http\Requests\ProjectInfoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Attachment;
use App\Models\Image;

class ProjectInfoController extends Controller
{
    public function showStock() {
        $projectInfo = ProjectInfo::where('user_id', 1)->get();
        return  ProjectInfoResource::collection($projectInfo);
    }

    public function show() {
        $user = Auth::user();
        $projectInfos = ProjectInfo::where('user_id', $user->id)->get();
        return ProjectInfoResource::collection($projectInfos);
    }

    public function store(ProjectInfoRequest $request) {
        $user = Auth::user();

        $projectInfo = ProjectInfo::create($request->all() + ['user_id' => $user->id]);
        return new ProjectInfoResource($projectInfo);
    }
    public function update(ProjectInfoRequest $request, int $id) {
        $user = Auth::user();

        $projectInfo = ProjectInfo::find($id);
        $projectInfo->update($request->all());
        return new ProjectInfoResource($projectInfo);
    }

    public function delete(int $id) {
        $projectInfo = ProjectInfo::where('id', $id)->first();
        $projectInfo->delete();
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
    $projectInfo = ProjectInfo::where('id', $id)->first();
    // if personal info doesn't have an attachment_id create a new one
    if (!$projectInfo->attachment) {
        $projectInfo->attachment()->create();  
        $projectInfo->load('attachment');
    } 

    foreach ($request->file('images') as $image) {
        // Save the image with the attachment ID
        $path = $image->store('images/projectInfo', 'public');
        $image = new Image();
        $image->url = Storage::url($path);
        $image->attachment_id = $projectInfo->attachment->id;
        $image->save();

        $uploadedImages[] = $image; // Add to the result list
    }

    return response()->json([
        'message' => 'Images uploaded successfully.',
        'images' => $uploadedImages,
    ]);
}


    public function removeImage(int $id, int $image_id){

        $projectInfo = ProjectInfo::where('id', $id)->first();

        $image = $projectInfo->attachment->images()->where('id', $image_id)->first();
        if ($image) {
            $oldImagePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($oldImagePath);
            $image->delete();
        }
        
        return response()->json(true, 204);; // No content
    }
}
