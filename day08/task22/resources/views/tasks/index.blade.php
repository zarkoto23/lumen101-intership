<x-app-layout>

    <x-slot name="header">
        Tasks
    </x-slot>


    <div class="py-12">

        <div class="max-w-6xl mx-auto px-6">


            <div class="flex justify-between items-center mb-8">

                <h1 class="page-title">
                    Tasks
                </h1>


                <a href="{{ route('tasks.create') }}" class="action-link">
                    + Create Task
                </a>

            </div>



            <div class="project-card mb-8">


                <h2 class="text-xl font-bold mb-5">
                    Filters
                </h2>



                <form method="GET" action="{{ route('tasks.index') }}">


                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">


                        <div>

                            <label>
                                Search
                            </label>

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search title...">

                        </div>



                        <div>

                            <label>
                                Project
                            </label>

                            <select name="project_id">

                                <option value="">
                                    All projects
                                </option>


                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>



                        <div>

                            <label>
                                Status
                            </label>


                            <select name="status">

                                <option value="">
                                    All
                                </option>

                                <option value="new">
                                    New
                                </option>

                                <option value="in_progress">
                                    In progress
                                </option>

                                <option value="review">
                                    Review
                                </option>

                                <option value="completed">
                                    Completed
                                </option>

                            </select>


                        </div>



                        <div>

                            <label>
                                Priority
                            </label>


                            <select name="priority">

                                <option value="">
                                    All
                                </option>

                                <option value="low">
                                    Low
                                </option>

                                <option value="medium">
                                    Medium
                                </option>

                                <option value="high">
                                    High
                                </option>

                            </select>

                        </div>



                        <div>

                            <label>
                                Assigned user
                            </label>


                            <select name="assigned_to">

                                <option value="">
                                    All users
                                </option>


                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach


                            </select>


                        </div>



                        <div>

                            <label>
                                Sort deadline
                            </label>


                            <select name="sort">

                                <option value="asc">
                                    Soonest
                                </option>


                                <option value="desc">
                                    Latest
                                </option>


                            </select>


                        </div>


                    </div>



                    <button type="submit" class="mt-6">
                        Apply Filters
                    </button>


                </form>


            </div>





            <div class="space-y-5">


                @foreach ($tasks as $task)
                    <div class="project-card">


                        <h2 class="text-xl font-bold mb-3">

                            <a href="{{ route('tasks.show', $task) }}" class="action-link">
                                {{ $task->title }}
                            </a>

                        </h2>



                        <p>
                            <strong>Project:</strong>
                            {{ $task->project->name }}
                        </p>



                        <p>
                            <strong>Status:</strong>
                            {{ ucfirst($task->status) }}
                        </p>



                        <p>
                            <strong>Priority:</strong>
                            {{ ucfirst($task->priority) }}
                        </p>



                        <p>
                            <strong>Deadline:</strong>
                            {{ $task->deadline }}
                        </p>



                    </div>
                @endforeach


            </div>



            <div class="mt-8">

                {{ $tasks->links() }}

            </div>



        </div>

    </div>


</x-app-layout>
