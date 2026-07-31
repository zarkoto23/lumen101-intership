<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateTaskRequest;

use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $projectIds = Auth::user()
        ->projects()
        ->pluck('projects.id');


    $tasks = Task::whereIn('project_id', $projectIds)
        ->with([
            'project',
            'assignedUser'
        ]);


    if ($request->filled('search')) {

        $tasks->where(
            'title',
            'like',
            '%' . $request->search . '%'
        );

    }


    if ($request->filled('project_id')) {

        $tasks->where(
            'project_id',
            $request->project_id
        );

    }


    if ($request->filled('status')) {

        $tasks->where(
            'status',
            $request->status
        );

    }


    if ($request->filled('priority')) {

        $tasks->where(
            'priority',
            $request->priority
        );

    }


    if ($request->filled('assigned_to')) {

        $tasks->where(
            'assigned_to',
            $request->assigned_to
        );

    }


    $tasks->orderBy(
        'deadline',
        $request->sort ?? 'asc'
    );


    $tasks = $tasks->paginate(5)
        ->withQueryString();



    $projects = Auth::user()
        ->projects()
        ->get();



    $users = Auth::user()
        ->projects()
        ->with('users')
        ->get()
        ->pluck('users')
        ->flatten()
        ->unique('id');



    return view('tasks.index', compact(
        'tasks',
        'projects',
        'users'
    ));
}

    public function create()
    {
        $projects = Auth::user()
            ->projects()
            ->with('users')
            ->get();

        if ($projects->isEmpty()) {
            return redirect()
                ->route('projects.index')
                ->with('error', 'Трябва първо да създадете или да бъдете добавен към проект.');
        }

        return view('tasks.create', compact('projects'));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();


        $project = Project::findOrFail($validated['project_id']);


        if (
            !$project->users()
                ->where('users.id', auth()->id())
                ->exists()
            &&
            $project->owner_id !== auth()->id()
        ) {
            abort(403);
        }


        $isMember = $project->users()
            ->where('users.id', $validated['assigned_to'])
            ->exists();


        if (!$isMember && $project->owner_id != $validated['assigned_to']) {
            return back()
                ->withErrors([
                    'assigned_to' => 'Потребителят не участва в този проект.'
                ]);
        }


        if ($validated['deadline'] > $project->deadline) {
            return back()
                ->withErrors([
                    'deadline' => 'Крайният срок на задачата не може да е след крайния срок на проекта.'
                ]);
        }


        $task = Task::create($validated);

        if ($validated['assigned_to'] != auth()->id()) {

            $user = User::findOrFail($validated['assigned_to']);

            $user->notify(
                new TaskAssignedNotification($task)
            );
        }


        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Задачата е създадена успешно.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load([
            'project',
            'assignedUser',
            'comments.user',
            'attachments.user',
            'statusHistories.user',
        ]);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);


        $projects = Auth::user()
            ->projects()
            ->with('users')
            ->get();


        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validated();

        $project = Project::findOrFail($validated['project_id']);

        if (
            !$project->users()
                ->where('users.id', auth()->id())
                ->exists()
            &&
            $project->owner_id !== auth()->id()
        ) {
            abort(403);
        }


        $isMember = $project->users()
            ->where('users.id', $validated['assigned_to'])
            ->exists();


        if (!$isMember && $project->owner_id != $validated['assigned_to']) {

            return back()
                ->withErrors([
                    'assigned_to' => 'Потребителят не участва в този проект.'
                ]);
        }


        if ($validated['deadline'] > $project->deadline) {
            return back()
                ->withErrors([
                    'deadline' => 'Крайният срок на задачата не може да е след крайния срок на проекта.'
                ]);
        }


        if ($task->status !== $validated['status']) {

            \App\Models\TaskStatusHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'old_status' => $task->status,
                'new_status' => $validated['status'],
            ]);


            $validated['status_changed_by'] = auth()->id();
            $validated['status_changed_at'] = now();
        }


        $task->update($validated);


        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Задачата е обновена успешно.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);


        DB::transaction(function () use ($task) {

            $task->comments()->delete();

            foreach ($task->attachments as $attachment) {

                if (Storage::exists($attachment->file_path)) {
                    Storage::delete($attachment->file_path);
                }

                $attachment->delete();
            }

            $task->statusHistories()->delete();

            $task->delete();
        });


        return redirect()
            ->route('tasks.index')
            ->with('success', 'Задачата е изтрита успешно.');
    }

    public function restore(Task $task)
{
    $this->authorize('restore', $task);

    $task->restore();

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Задачата е възстановена успешно.');
}

public function deleted()
{
    $tasks = Task::onlyTrashed()
        ->whereHas('project.users', function ($query) {
            $query->where('users.id', auth()->id());
        })
        ->paginate(10);

    return view('tasks.deleted', compact('tasks'));
}

public function kanban()
{
    $tasks = Auth::user()
        ->projects()
        ->with('tasks')
        ->get()
        ->pluck('tasks')
        ->flatten()
        ->groupBy('status');


    return view('tasks.kanban', compact('tasks'));
}
}
