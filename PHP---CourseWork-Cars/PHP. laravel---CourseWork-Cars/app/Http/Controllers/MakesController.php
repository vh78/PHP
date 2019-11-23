<?php

namespace App\Http\Controllers;

use App\Makes;
use Illuminate\Http\Request;
use App\Cars;
use App\Models;
use Illuminate\Support\Facades\Validator;

class MakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $makes = Makes::latest()->paginate(50);

        return view("makes.index", compact("makes"))->with('i', (request()->input('page', 1) - 1) * 50);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makes = Makes::all();
        return view('makes.create')->with('makes', $makes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'year' => 'required'
        );

      /*  print '<pre>';
        print_r($request->all());
        die;*/

        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('makes/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {


            $makesDate = \DateTime::createFromFormat('Y', $request->get('year'));
            $makes = new Makes([
                'name' => $request->get('name'),
                'year' => $makesDate
            ]);
            $makes->save();
            return redirect('makes');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $make = Makes::find($id);
        return view('makes.show', ["make" => $make]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $makes = Makes::find($id);
        return view('makes.edit', compact('makes','id'))->with('makes', $makes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $make = Makes::find($id);
        $make->name = $request->get('name');
        $make->year = $request->get('year');
        $make->save();
        return redirect('makes')->with('success', 'Task was successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $makes = Makes::find($id);
        $makes->delete();
        return redirect('makes')->with('message', 'Car was deleted!');
    }
}
