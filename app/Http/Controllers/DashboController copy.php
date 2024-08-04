<?php

namespace App\Http\Controllers;

use App\Models\Dashbo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dashbos = Dashbo::all();       
        return view('dashboard',['dashbos'=>$dashbos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashbo $dashbo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashbo $dashbo): View
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashbo $dashbo): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashbo $dashbo): RedirectResponse
    {
        //
    }
}
