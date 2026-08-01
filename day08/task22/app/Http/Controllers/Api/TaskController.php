<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with([
            'project',
            'assignedUser'
        ])
            ->get();

        return response()->json($tasks);
    }
}
