<?php

namespace App\Http\Controllers;

use App\ViewModels\MoviesViewModel;
use App\ViewModels\MovieViewModel;
use Illuminate\Support\Facades\App;
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
        $locale = App::getLocale() === 'ru' ? 'ru-RU' : 'en-US';

        $popularMoviesResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/movie/popular', [
                'language' => $locale,
            ]);

        if ($popularMoviesResponse->successful()) {
            $popularMovies = $popularMoviesResponse->json()['results'];
        } else {
            dd('Error fetching popular movies:', $popularMoviesResponse->json());
        }

        $nowPlayingMoviesResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/movie/now_playing', [
                'language' => $locale,
            ]);

        if ($nowPlayingMoviesResponse->successful()) {
            $nowPlayingMovies = $nowPlayingMoviesResponse->json()['results'];
        } else {
            dd('Error fetching now playing movies:', $nowPlayingMoviesResponse->json());
        }

        $genresResponse = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/genre/movie/list', [
                'language' => $locale,
            ]);

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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locale = App::getLocale() === 'ru' ? 'ru-RU' : 'en-US';

        $movie = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get("https://api.themoviedb.org/3/movie/{$id}", [
                'append_to_response' => 'credits,videos,images,translations',
                'language' => $locale,
            ])
            ->json();

        if ($locale === 'ru-RU') {
            if (isset($movie['translations']) && isset($movie['translations']['translations'])) {
                foreach ($movie['translations']['translations'] as $translation) {
                    if ($translation['iso_639_1'] === 'ru') {
                        $movie['overview'] = $translation['data']['overview'] ?? $movie['overview'];
                        break;
                    }
                }
            }
        }

        $viewModel = new MovieViewModel($movie);

        return view('movies.show', $viewModel);
    }

}
