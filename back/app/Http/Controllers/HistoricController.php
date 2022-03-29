<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    public function __construct(Historic $historic) {
        $this->historic = $historic;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historic = Historic::all();
        return response()->json($historic);
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
        $historic = Historic::create($request->all());
        return response()->json($historic);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Historic  $Historic
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $historic = $this->historic->where('user_id', $user_id)->get();
        return response()->json($historic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historic  $Historic
     * @return \Illuminate\Http\Response
     */
    public function edit(Historic $historic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historic  $Historic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historic $historic)
    {
        $historic->update($request->all());
        return response()->json($historic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historic  $Historic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historic $historic)
    {
        $historic->delete();
        return response()->json(['message' => 'Histórico apagado com sucesso!']);
    }
}
