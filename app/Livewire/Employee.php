<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;

    public $updateMode = false;

    #[Validate(['required'], message: [
        'name.required' => 'Nama Lengkap tidak boleh kosong!',
    ])]
    public $name = '';

    #[Validate(['required', 'email'], message: [
        'email.required' => 'Email tidak boleh kosong!',
        'email.email'    => 'Email tidak valid!',
    ])]
    public $email = '';

    #[Validate(['required'], message: [
        'address.required' => 'Alamat tidak boleh kosong!',
    ])]
    public $address = '';

    public $search = '';
    public $employee_id = '';
    public $employee_selected_id = [];

    public function store()
    {
        $this->validate();

        \App\Models\Employee::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'address' => $this->address,
        ]);

        $this->clear();

        session()->flash('message', 'Data Pegawai berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $employee = \App\Models\Employee::find($id);

        $this->name        = $employee->name;
        $this->email       = $employee->email;
        $this->address     = $employee->address;
        $this->employee_id = $id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        $employee = \App\Models\Employee::find($this->employee_id);

        $employee->update([
            'name'    => $this->name,
            'email'   => $this->email,
            'address' => $this->address,
        ]);

        $this->clear();

        session()->flash('message', 'Data Pegawai berhasil diubah!');
    }

    public function confirm_delete($id)
    {
        if ($id) {
            $this->employee_id = $id;
        }
    }

    public function delete()
    {
        if ($this->employee_id) {
            $employee = \App\Models\Employee::find($this->employee_id);
            $employee->delete();
        }

        if (count($this->employee_selected_id) > 0) {
            \App\Models\Employee::query()->whereIn('id', $this->employee_selected_id)->delete();
        }

        $this->clear();

        session()->flash('message', 'Data Pegawai berhasil dihapus!');
    }

    public function clear()
    {
        $this->updateMode = false;

        $this->name   = '';
        $this->email  = '';
        $this->alamat = '';

        $this->search               = '';
        $this->employee_id          = '';
        $this->employee_selected_id = [];
    }

    public function render()
    {
        $employees = \App\Models\Employee::query()->filter([
            'search' => $this->search,
        ])->orderBy('id')->paginate(15)->withQueryString();

        return view('livewire.employee', [
            'employees' => $employees,
        ]);
    }
}
