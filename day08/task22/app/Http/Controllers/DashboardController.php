<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        $totalProjects = $user->projects()->count();

        $projectIds = $user->projects()
            ->pluck('projects.id');


        $tasks = Task::whereIn(
            'project_id',
            $projectIds
        );


        $totalTasks = $tasks->count();


        $completedTasks = Task::whereIn(
            'project_id',
            $projectIds
        )
            ->where('status', 'completed')
            ->count();



        $overdueTasks = Task::whereIn(
            'project_id',
            $projectIds
        )
            ->where('deadline', '<', now())
            ->where('status', '!=', 'completed')
            ->count();



        $highPriorityTasks = Task::whereIn(
            'project_id',
            $projectIds
        )
            ->where('priority', 'high')
            ->count();



        $mostActiveProject = $user->projects()
            ->withCount('tasks')
            ->orderByDesc('tasks_count')
            ->first();



        $upcomingTasks = Task::whereIn(
            'project_id',
            $projectIds
        )
            ->where('status', '!=', 'completed')
            ->whereBetween(
                'deadline',
                [
                    now(),
                    now()->addDays(7)
                ]
            )
            ->orderBy('deadline')
            ->take(5)
            ->get();



        return view('dashboard.index', compact(
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'overdueTasks',
            'highPriorityTasks',
            'mostActiveProject',
            'upcomingTasks'
        ));
    }
}
