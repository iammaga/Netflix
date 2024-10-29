<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\MovieViewModel;
use App\ViewModels\MoviesViewModel;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularMoviesResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/movie/popular');

        if ($popularMoviesResponse->successful()) {
            $popularMovies = $popularMoviesResponse->json()['results'];
        } else {
            dd('Error fetching popular movies:', $popularMoviesResponse->json());
        }

        $nowPlayingMoviesResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/movie/now_playing');

        if ($nowPlayingMoviesResponse->successful()) {
            $nowPlayingMovies = $nowPlayingMoviesResponse->json()['results'];
        } else {
            dd('Error fetching now playing movies:', $nowPlayingMoviesResponse->json());
        }

        $genresResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/genre/movie/list');

        if ($genresResponse->successful()) {
            $genres = $genresResponse->json()['genres'];
        } else {
            dd('Error fetching genres:', $genresResponse->json());
        }

        $viewModel = new MoviesViewModel(
            $popularMovies,
            $nowPlayingMovies,
            $genres,
        );

        return view('movies.index', $viewModel);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/movie/'.$id.'?append_to_response=credits,videos,images')
            ->json();

        $viewModel = new MovieViewModel($movie);

        return view('movies.show', $viewModel);
    }
}
