<?php

namespace App\Http\Controllers;

use App\ViewModels\ActorsViewModel;
use App\ViewModels\ActorViewModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        abort_if($page > 500, 204);

        $locale = App::getLocale() === 'ru' ? 'ru-RU' : 'en-US';
        $popularActors = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get('https://api.themoviedb.org/3/person/popular', [
                'page' => $page,
                'language' => $locale,
            ])
            ->json()['results'];

        $viewModel = new ActorsViewModel($popularActors, $page);

        return view('actors.index', $viewModel);
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
        $actor = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get("https://api.themoviedb.org/3/person/{$id}", [
                'language' => $locale,
            ])
            ->json();

        $social = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get("https://api.themoviedb.org/3/person/{$id}/external_ids")
            ->json();

        $credits = Http::withToken(config('services.tmdb.token'))
            ->withOptions(['verify' => false])
            ->get("https://api.themoviedb.org/3/person/{$id}/combined_credits", [
                'language' => $locale,
            ])
            ->json();

        $viewModel = new ActorViewModel($actor, $social, $credits);

        return view('actors.show', $viewModel);
    }
}
