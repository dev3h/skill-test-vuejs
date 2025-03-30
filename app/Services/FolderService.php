<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Resources\FileResource;
use App\Http\Resources\FolderResource;
use App\Models\Folder;

class FolderService
{
    public function index()
    {
        try {
            $folders = Folder::whereNull('parent_id')->get();
            return FolderResource::collection($folders)->additional(["status" => 200]);
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorResponse('Something went wrong', $e->getMessage());
        }
    }

    public function showFile($request, $id)
    {
        try {
            $folder = Folder::where('id', $id)->first();
            $query = $folder->files();

            if ($request->filled('s')) {
                $query->where('name', 'like', '%' . $request->s . '%');
            }

            if ($request->filled('photo_by') && is_array($request->photo_by)) {
                if (!in_array('all', $request->photo_by)) {
                     $query->whereHas('user', function ($q) use ($request) {
                        $q->whereIn('id', $request->photo_by);
                    });
                }
            }

            $files = $query->get();
            return FileResource::collection($files)->additional(["status" => 200]);
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorResponse('Something went wrong', $e->getMessage());
        }
    }
}