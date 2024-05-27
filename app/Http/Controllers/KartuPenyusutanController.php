<?php

namespace App\Http\Controllers;

use App\Models\KartuPenyusutan;
use Illuminate\Http\Request;

class KartuPenyusutanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kartu_penyusutan.index');
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
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function show(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function edit(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuPenyusutan $kartuPenyusutan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuPenyusutan  $kartuPenyusutan
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuPenyusutan $kartuPenyusutan)
    {
        //
    }
}
