<?php

namespace App\Http\Controllers;

use App\Models\Serie;
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

        ray($details);

        if ($details && !isset($details->success)) {
            $serieDetails = new \App\Models\SerieDetails([
                'adult' => $details->adult ?? null,
                'first_air_date' => $details->first_air_date ? \Carbon\Carbon::parse($details->first_air_date) : null,
                'last_air_date' => $details->last_air_date ? \Carbon\Carbon::parse($details->last_air_date) : null,
                'original_language' => $details->original_language ?? null,
                'status' => $details->status ?? null,
                'overview' => $details->overview ?? null
            ]);
            $serie->detailed_info = true;
            $serie->save();
            $serie->details()->updateOrCreate($serieDetails->toArray());
        }

        return view('series.show', [
            'serie' => $serie
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
