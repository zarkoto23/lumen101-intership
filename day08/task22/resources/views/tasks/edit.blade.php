<x-app-layout>

    <x-slot name="header">
        Edit Task
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 sm:px-8">


            <form method="POST" action="{{ route('tasks.update', $task) }}">

                @csrf
                @method('PUT')


                <div>
                    <label>Project</label>

                    <select name="project_id">

                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ $task->project_id == $project->id ? 'selected' : '' }}>

                                {{ $project->name }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div>
                    <label>Title</label>

                    <input type="text" name="title" value="{{ $task->title }}">

                </div>


                <div>
                    <label>Description</label>

                    <textarea name="description">{{ $task->description }}</textarea>
                </div>


                <div>
                    <label>Assigned user</label>

                    <select name="assigned_to">


                        @foreach ($projects as $project)
                            @foreach ($project->users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $task->assigned_to == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }}

                                </option>
                            @endforeach
                        @endforeach


                    </select>

                </div>


                <div>
                    <label>Priority</label>

                    <select name="priority">

                        <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>
                            High
                        </option>

                    </select>

                </div>


                <div>
                    <label>Status</label>

                    <select name="status">

                        <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>
                            New
                        </option>

                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                            In Progress
                        </option>

                        <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>
                            Review
                        </option>

                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                </div>


                <div>
                    <label>Deadline</label>

                    <input type="date" name="deadline"
                        value="{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}">

                </div>


                <button type="submit">
                    Save
                </button>


            </form>


        </div>

    </div>


</x-app-layout>
