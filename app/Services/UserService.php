<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use App\Models\User;

class UserService
{
    public function index()
    {
        try {
            $users = User::select('id', 'name')->get();
            return ResponseHelper::sendSuccessResponse($users);
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorResponse('Something went wrong', $e->getMessage());
        }
    }
}