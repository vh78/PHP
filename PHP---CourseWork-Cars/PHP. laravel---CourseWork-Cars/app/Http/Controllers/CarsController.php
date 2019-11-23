<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Cars;
use App\Models;
use App\Makes;
use Illuminate\Support\Facades\Validator;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $cars = Cars::latest()->paginate(50);

        return view("cars.index")->with('cars', $cars);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makes = Makes::all();
        $models = Models::all();
        return view('cars.create')->with('makes', $makes)->with('models', $models);
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

        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'model_id'       => 'required',
            'year' => 'required',
            'km' => 'required'
        );

        /*print '<pre>';
        print_r($request->all());
        die;*/

        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return redirect('cars/create')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {

            $carDate = \DateTime::createFromFormat('Y', $request->get('year'));

            $cars = new Cars([
                'model_id' => $request->get('model_id'),
                'year' => $carDate,
                'km' => $request->get('km'),
            ]);
            $cars->save();
            return redirect('cars');
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
        $car = Cars::find($id);
        return view('cars.show', ["car" => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cars = Cars::find($id);
        $models = Models::all();
        return view('cars.edit', compact('cars','id'))->with('cars',$cars)->with('models', $models);

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

        $car = Cars::find($id);
        $car->model_id = $request->get('model_id');
        $car->year = $request->get('year');
        $car->km = $request->get('km');
        $car->save();
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
        $cars = Cars::find($id);
        $cars->delete();
        return redirect('cars')->with('message', 'Car was deleted!');
    }
}
