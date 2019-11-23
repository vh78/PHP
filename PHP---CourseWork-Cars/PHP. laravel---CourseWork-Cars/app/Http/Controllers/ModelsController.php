<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cars;
use App\Models;
use App\Makes;
use Illuminate\Support\Facades\Validator;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Models::latest()->paginate(50);

        return view("models.index", compact("models"))->with('i', (request()->input('page', 1) - 1) * 50);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makes = Makes::all();
        return view('models.create')->with('makes', $makes);
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
            'makes_id' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('models/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {


            $models = new Models([
                'name' => $request->get('name'),
                'makes_id' =>  $request->get('makes_id')
                ,
            ]);
            $models->save();
            return redirect('models');
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
        $model = Models::find($id);
        return view('models.show', ["model" => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $models = Models::find($id);
        return view('models.edit', compact('models','id'));
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
        $model = Models::find($id);
        $model->name = $request->get('name');
        $model->makes_id = $request->get('makes_id');
        $model->save();
        return redirect('cars')->with('success', 'Task was successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $models = Models::find($id);
        $models->delete();
        return redirect('models')->with('message', 'Car was deleted!');
    }
}
