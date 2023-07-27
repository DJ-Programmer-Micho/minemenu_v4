<div>

    @include('dashboard.livewire.user-table-modal')
    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b>TABLE USER</b>
        </h2>
        <div class="row d-flex justify-content-between">
            <div>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model="search" class="form-control bg-white text-black"
                        placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h2>
            </div>
            <div>
                <div class="">
                    <button class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#studentModal">{{__('Add New Menu')}}</button>
                </div>
            </div>
            <div class="col-md-12">
                @if (session()->has('message'))
                <h5 class="alert alert-success">{{ session('message') }}</h5>
                @endif
                <div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-5">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Course</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->role }}</td>
                        <td>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#updateStudentModal"
                                wire:click="editStudent({{$student->id}})" class="btn btn-primary">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteStudentModal"
                                wire:click="deleteStudent({{$student->id}})" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $students->links() }}
        </div>

    </div>
</div>
</div>

</div>
