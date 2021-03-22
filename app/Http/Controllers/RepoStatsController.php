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
        $attributes = $this->validate($request, [
            'stars' => 'required',
            'forks' => 'required',
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
