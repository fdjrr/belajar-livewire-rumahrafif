<div>
    <div class="row">
        @if (session()->has('message'))
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        </div>
        @endif
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <form wire:submit="{{ $updateMode ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" wire:model="name" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="email" value="{{ $email }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" wire:model="address" value="{{ $address }}" class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    Data Pegawai
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Cari Pegawai">
                    </div>
                    @if ($employee_selected_id)
                    <button wire:click="confirm_delete('')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger btn-sm">Delete ({{ count($employee_selected_id) }})</button>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                            <tr>
                                <td>
                                    <input type="checkbox" wire:key="{{ $employee->id }}" value="{{ $employee->id }}" wire:model.live="employee_selected_id">
                                </td>
                                <th scope="row">{{ $employees->firstItem() + $loop->index }}</th>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    <button wire:click="confirm_delete({{ $employee->id }})" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger btn-sm">Delete</button>
                                    <button wire:click="edit({{ $employee->id }})" type="button" class="btn btn-warning btn-sm">Edit</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%">Data not found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin untuk menghapus Data Pegawai?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" wire:click="delete({{ $employee_id }})" class="btn btn-primary" data-bs-dismiss="modal">Yakin</button>
                </div>
            </div>
        </div>
    </div>
</div>