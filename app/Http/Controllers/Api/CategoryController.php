<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(RoomCategory::withCount('rooms')->get());
    }
}