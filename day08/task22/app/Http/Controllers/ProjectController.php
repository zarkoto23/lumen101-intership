<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()
            ->projects()
            ->with('owner')
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }


    public function create()
    {
        return view('projects.create');
    }


    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = DB::transaction(function () use ($validated) {

            $project = Project::create([
                'owner_id' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'deadline' => $validated['deadline'],
                'status' => $validated['status'],
            ]);


            $project->users()->attach(auth()->id(), [
                'role' => 'manager'
            ]);


            return $project;
        });


        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Проектът е създаден успешно.');
    }


    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $users = User::whereNotIn(
            'id',
            $project->users()->pluck('users.id')
        )->get();

        $project->load('users');

        return view('projects.show', compact('project', 'users'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);


        return view('projects.edit', compact('project'));
    }


    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);


        if ($validated['status'] === 'completed') {

            $unfinishedTasks = $project->tasks()
                ->where('status', '!=', 'completed')
                ->exists();


            if ($unfinishedTasks) {

                return back()
                    ->withErrors([
                        'status' => 'Проектът не може да бъде завършен, докато има незавършени задачи.'
                    ]);
            }
        }


        $project->update($validated);


        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Проектът е обновен успешно.');
    }


    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);


        DB::transaction(function () use ($project) {

            foreach ($project->tasks as $task) {

                foreach ($task->attachments as $attachment) {

                    if (Storage::exists($attachment->file_path)) {
                        Storage::delete($attachment->file_path);
                    }

                    $attachment->delete();
                }


                $task->comments()->delete();

                $task->statusHistories()->delete();

                $task->delete();
            }




            $project->delete();
        });


        return redirect()
            ->route('projects.index')
            ->with('success', 'Проектът е изтрит успешно.');
    }


    public function deleted()
    {
        $projects = Project::onlyTrashed()
            ->where('owner_id', auth()->id())
            ->paginate(10);

        return view('projects.deleted', compact('projects'));
    }



    public function addUser(Request $request, Project $project)
    {
        $this->authorize('update', $project);


        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:manager,developer,tester',
        ]);


        DB::transaction(function () use ($project, $validated) {

            DB::transaction(function () use ($project, $validated) {

                $project->users()->syncWithoutDetaching([

                    $validated['user_id'] => [
                        'role' => $validated['role']
                    ]

                ]);
            });
        });


        return back()
            ->with('success', 'Участникът е добавен успешно.');
    }


    public function removeUser(Project $project, User $user)
    {
        $this->authorize('update', $project);


        if ($project->owner_id === $user->id) {

            return back()
                ->withErrors([
                    'user' => 'Собственикът на проекта не може да бъде премахнат.'
                ]);
        }


        $project->users()->detach($user->id);


        return back()
            ->with('success', 'Участникът е премахнат.');
    }



    public function updateUserRole(Request $request, Project $project, User $user)
    {
        $this->authorize('update', $project);


        $validated = $request->validate([
            'role' => 'required|in:manager,developer,tester',
        ]);


        $project->users()->updateExistingPivot(
            $user->id,
            [
                'role' => $validated['role']
            ]
        );


        return back()
            ->with('success', 'Ролята е обновена.');
    }

    public function restore(Project $project)
    {
        $this->authorize('restore', $project);

        $project->restore();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Проектът е възстановен успешно.');
    }
}
