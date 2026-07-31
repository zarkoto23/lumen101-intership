<x-app-layout>

    <x-slot name="header">
        Projects
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="flex justify-between items-center mb-8">

                <h1 class="page-title">
                    Projects
                </h1>


                <a 
                    href="{{ route('projects.create') }}"
                    class="action-link"
                >
                    + Create Project
                </a>

            </div>



            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                @foreach($projects as $project)


                    <div class="project-card">


                        <h2 class="text-xl font-bold mb-3">

                            <a 
                                href="{{ route('projects.show', $project) }}"
                                class="action-link"
                            >
                                {{ $project->name }}
                            </a>

                        </h2>



                        <p class="text-gray-600 mb-4">

                            {{ $project->description }}

                        </p>



                        <div class="mb-4">

                            <span class="status-badge status-new">

                                {{ ucfirst($project->status) }}

                            </span>

                        </div>



                        <div class="flex gap-3">


                            <a 
                                href="{{ route('projects.show', $project) }}"
                                class="action-link"
                            >
                                View
                            </a>



                            @if($project->owner_id == auth()->id())

                                <a 
                                    href="{{ route('projects.edit', $project) }}"
                                    class="action-link"
                                >
                                    Edit
                                </a>

                            @endif


                        </div>


                    </div>


                @endforeach


            </div>



            <div class="mt-8">

                {{ $projects->links() }}

            </div>



        </div>

    </div>


</x-app-layout>