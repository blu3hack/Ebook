<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchEbook extends Component
{
    public $search = '';
    public function render()
    {
       $ebooks = DB::table('ebook')
        ->where('ebook', 'like', '%' . $this->search . '%')
        ->orWhere('author', 'like', '%' . $this->search . '%')
        ->orWhere('kelas', 'like', '%' . $this->search . '%')
        ->get();

        return view('livewire.search-ebook', [
            'ebooks' => $ebooks,
        ]);
    }
}
