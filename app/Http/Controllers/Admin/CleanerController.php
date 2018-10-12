<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCleanerRequest;
use App\Http\Controllers\Controller;

use App\Cleaner;
use App\City;
use Illuminate\Http\Request;
use Session;

class CleanerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cleaner = Cleaner::with('cities')->paginate(25);

        return view('cleaner.index', compact('cleaner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cleaner.create', [
            'cities' => City::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCleanerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCleanerRequest $request)
    {
        $requestData = $request->all();

        $cleaner = Cleaner::create($requestData);
        $cleaner->cities()->sync($request->input('cities'));

        Session::flash('flash_message', 'Cleaner added!');

        return redirect('cleaner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $cleaner = Cleaner::findOrFail($id);

        return view('cleaner.show', compact('cleaner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $cleaner = Cleaner::findOrFail($id);
        $cities = City::get();

        return view('cleaner.edit', compact('cleaner', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \App\Http\Requests\StoreCleanerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, StoreCleanerRequest $request)
    {        
        $requestData = $request->all();
        
        $cleaner = Cleaner::findOrFail($id);
        $cleaner->update($requestData);
        $cleaner->cities()->sync($request->input('cities'));

        Session::flash('flash_message', 'Cleaner updated!');

        return redirect('cleaner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Cleaner::destroy($id);

        Session::flash('flash_message', 'Cleaner deleted!');

        return redirect('cleaner');
    }
}
