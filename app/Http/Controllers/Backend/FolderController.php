<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\FolderService;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    protected $folderService;
    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }
    public function index()
    {
        return $this->folderService->index();
    }
    public function showFile(Request $request, $id)
    {
        return $this->folderService->showFile($request, $id);
    }
}
