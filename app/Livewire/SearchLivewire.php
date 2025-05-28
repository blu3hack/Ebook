<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchLivewire extends Component
{
    public $search = '';
    public function render()
    {
       $users = User::where('Nama', 'like', '%' . $this->search . '%')
                ->orWhere('Username', 'like', '%' . $this->search . '%')
                ->orWhere('role', 'like', '%' . $this->search . '%')
                ->orWhere('Kelas', 'like', '%' . $this->search . '%')
                ->get();
        return view('livewire.search-livewire', [
            'users' => $users, // <-- ini penting!
        ]);
    }
}
