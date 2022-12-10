<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Serie;
use App\Jobs\GetEpisodes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $series = Serie::orderBy('id', 'asc')->paginate(20);

        return view('series.index', [
            'series' => $series
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function indexWatchlist()
    {
        $series = Serie::where('on_watchlist', true)->orderBy('title', 'asc')->paginate(20);

        return view('series.watchlist', [
            'series' => $series
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $serie = Serie::where('id', $id)->first();

        $details = new \App\Actions\MovieDB\GetSerieDetails();
        $details = $details->execute($serie->tmdb_id);

        if ($details && !isset($details->success)) {
            $serieDetails = new \App\Models\SerieDetails([
                'adult' => $details->adult ?? null,
                'first_air_date' => $details->first_air_date ? \Carbon\Carbon::parse($details->first_air_date) : null,
                'last_air_date' => $details->last_air_date ? \Carbon\Carbon::parse($details->last_air_date) : null,
                'original_language' => $details->original_language ?? null,
                'status' => $details->status ?? null,
                'overview' => $details->overview ?? null,
                'tagline' => $details->tagline ?? null
            ]);
            $serie->detailed_info = true;
            $serie->save();
            $serie->details()->updateOrCreate(['serie_id' => $serie->id], $serieDetails->toArray());
        }

        foreach($details->seasons as $seasonApi) {
            Season::updateOrCreate(
                [
                    'serie_id' => $serie->id,
                    'name' => $seasonApi->name
                ], [
                    'overview' => $seasonApi->overview ?? null,
                    'poster_path' => $seasonApi->poster_path ?? null,
                    'air_date' => $seasonApi->air_date ? \Carbon\Carbon::parse($seasonApi->air_date) : null,
                    'episode_count' => $seasonApi->episode_count ?? null,
                    'season_number' => $seasonApi->season_number ?? null,
                    'tmdb_id' => $seasonApi->id ?? null,
                ]
            );
        }

        foreach($serie->seasons as $season) {
            GetEpisodes::dispatch($season);
        }

        return view('series.show', [
            'serie' => $serie
        ]);
    }

    /**
     * Display new content for watched series.
     *
     * @return Application|Factory|View
     */
    public function newEpisodes()
    {
        $series = Serie::where('on_watchlist', true)->get();

        foreach ($series as $serie) {
            $season = $serie->getLastSeason();
            $freshContent = new \App\Actions\MovieDB\GetChanges();
            $freshContent = $freshContent->execute($season->tmdb_id);
            ray($freshContent);
        }

        return view('series.new', [
            'series' => $series
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
