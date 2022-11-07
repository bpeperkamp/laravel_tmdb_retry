<?php

namespace App\Http\Livewire;

use App\Models\Serie;
use Livewire\Component;

class MarkWatchlist extends Component
{
    public $on_watchlist;

    public $serie;

    protected $listeners = [
        'markOnWatchlist' => 'watchlist'
    ];

    public function mount($serie)
    {
        $this->on_watchlist = $serie->on_watchlist;
    }

    public function watchlist()
    {
        $serie = Serie::where('id', '=', $this->serie['id'])->first();

        // Get detail on show. Rewrite later to do this when series is on whatch list.
        $getDetail = new \App\Actions\MovieDB\GetSerieDetails();
        $getDetail->execute($serie->tmdb_id);

        $serie->on_watchlist = $serie->on_watchlist ? false : true;
        $serie->save();
    }

    public function render()
    {
        return view('livewire.mark-watchlist');
    }
}
