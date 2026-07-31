<x-app-layout>

    <x-slot name="header">
        Dashboard
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <h1 class="page-title mb-8">
                Dashboard
            </h1>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                <div class="project-card">
                    <h3 class="font-bold text-gray-500">
                        Projects
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalProjects }}
                    </p>
                </div>



                <div class="project-card">
                    <h3 class="font-bold text-gray-500">
                        Tasks
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $totalTasks }}
                    </p>
                </div>



                <div class="project-card">
                    <h3 class="font-bold text-gray-500">
                        Completed
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $completedTasks }}
                    </p>
                </div>



                <div class="project-card">
                    <h3 class="font-bold text-gray-500">
                        Overdue
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $overdueTasks }}
                    </p>
                </div>



                <div class="project-card">
                    <h3 class="font-bold text-gray-500">
                        High priority
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $highPriorityTasks }}
                    </p>
                </div>



                <div class="project-card">

                    <h3 class="font-bold text-gray-500">
                        Most active project
                    </h3>


                    @if ($mostActiveProject)
                        <p class="mt-3 text-xl font-bold">
                            {{ $mostActiveProject->name }}
                        </p>


                        <p>
                            Tasks:
                            {{ $mostActiveProject->tasks_count }}
                        </p>
                    @else
                        <p class="mt-3">
                            No projects
                        </p>
                    @endif

                </div>


            </div>



            <div class="project-card mt-8">


                <h2 class="text-xl font-bold mb-5">
                    Upcoming deadlines
                </h2>



                @forelse($upcomingTasks as $task)
                    <div class="border-b py-3">

                        <a class="action-link" href="{{ route('tasks.show', $task) }}">
                            {{ $task->title }}
                        </a>


                        <p class="text-gray-500 mt-2">
                            Deadline:
                            {{ $task->deadline }}
                        </p>

                    </div>


                @empty

                    <p>
                        No upcoming tasks
                    </p>
                @endforelse


            </div>


        </div>

    </div>


</x-app-layout>
