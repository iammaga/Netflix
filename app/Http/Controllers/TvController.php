<?php

namespace App\Http\Controllers;

use App\ViewModels\TvShowViewModel;
use App\ViewModels\TvViewModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = App::getLocale() === 'ru' ? 'ru-RU' : 'en-US';
        $popularTv = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/tv/popular', [
                'language' => $locale,
            ])
            ->json()['results'];

        $topRatedTv = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/tv/top_rated', [
                'language' => $locale,
            ])
            ->json()['results'];

        $genres = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/genre/tv/list', [
                'language' => $locale,
            ])
            ->json()['genres'];

        $viewModel = new TvViewModel(
            $popularTv,
            $topRatedTv,
            $genres,
        );

        return view('tv.index', $viewModel);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locale = App::getLocale() === 'ru' ? 'ru-RU' : 'en-US';

        $tvshow = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get("https://api.themoviedb.org/3/tv/{$id}", [
                'append_to_response' => 'credits,videos,images',
                'language' => $locale,
            ])
            ->json();

        $viewModel = new TvShowViewModel($tvshow);

        return view('tv.show', $viewModel);
    }
}
