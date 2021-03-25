<?php

namespace App\Http\Controllers;

use App\RepoStat;
use Illuminate\Http\Request;

class RepoStatsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //repostats?stars=1&forks=1&commits=12&releases=2&contributors=9&languages=2&open_issues=2&open_pull_requests=4&branches=3
        $attributes = $this->validate($request, [
            'stars' => 'required',
            'forks' => 'required',
            'commits' => 'required',
            'releases' => 'required',
            'contributors' => 'required',
            'languages' => 'required',
            'open_issues' => 'required',
            'open_pull_requests' => 'required',
            'branches' => 'required',
        ]);
      
        RepoStat::create($attributes);

        return response()->json(['Stat recorded.']);
    }
}

