<div>

    @include('dashboard.livewire.user-table-modal')
    <div class="m-4">
        <h2 class="text-lg font-medium mr-auto">
            <b>TABLE USER</b>
        </h2>
        <div class="row d-flex justify-content-between m-0">
            <div>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model="search" class="form-control bg-white text-black"
                        placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h2>
            </div>
            <div>
                <div class="">
                    <button class="btn btn-info" data-toggle="modal"
                        data-target="#studentModal">{{__('Add New Menu')}}</button>
                </div>
            </div>
        </div>
        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col)
                        <th>{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $user)
                    <tr>
                        @foreach ($cols_td as $col)
                        <td>
                            @if ($col === 'status')
                                <span class="{{ $user->status == 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $user->status == 1 ? __('Active') : 'Deactive' }}
                                </span>
                            @else
                                {{ data_get($user, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <button type="button" data-toggle="modal" data-target="#updateStudentModal"
                                wire:click="editStudent({{ $user->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteStudentModal"
                                wire:click="deleteStudent({{ $user->id }})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button"
                                wire:click="updateStatus({{ $user->id }})"
                                class="btn {{ $user->status == 1 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $user->status == 1 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
                
                {{-- <tbody>
                    @forelse ($students as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="{{ $user->status == 1 ? 'text-success' : 'text-danger' }}">
                                {{ $user->status == 1 ? 'Active' : 'Deactive' }}
                            </span>
                        </td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#updateStudentModal"
                                wire:click="editStudent({{$user->id}})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteStudentModal"
                                wire:click="deleteStudent({{$user->id}})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button"
                                wire:click="updateStatus({{$user->id}})" class="btn {{ $user->status == 1 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $user->status == 1 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{$colspan}}">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody> --}}
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $students->links() }}
        </div>

    </div>
</div>
</div>

</div>
