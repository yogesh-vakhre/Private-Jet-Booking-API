<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Http\Traits\ApiHelpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    use ApiHelpers; // Using the apiHelpers Trait

    /**
     * Get all projects with their associated tasks and users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get query string parameters
        $searchKeyword = $request->input('q', ''); // search keyword, default to empty string
        $pageIndex = $request->input('pageIndex', 0); // page index, default to 0
        $pageSize = $request->input('pageSize', 3); // page size, default to 3
        $sortBy = $request->input('sortBy', 'name'); // attribute to sort, default to 'name'
        $sortDirection = $request->input('sortDirection', 'ASC'); // sort direction, default to 'ASC'

        // Query Healthcare Professional
        $query = Flight::query();

        // Apply search keyword filter
        if ($searchKeyword) {
            $query->where('id', 'like', '%' . $searchKeyword . '%');
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Get total count of Healthcare Professional
        $totalCount = $query->count();

        // Apply pagination
        $query->skip($pageIndex * $pageSize)->take($pageSize);

        // Fetch Healthcare Professional
        $flight = $query->get();

        // Return response

        return $this->onSuccess([
                'flight' => $flight,
                'totalCount' => $totalCount,
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy,
                'sortDirection' => $sortDirection,
            ],
            'Flight All Retrieved'
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
           $errors = $validator->errors();
           return $this->onError(404,'Validation Error.',$errors);
        }

        $flight = Flight::create($request->all());

        return $this->onSuccess($flight, 'Flight Created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        return $this->onSuccess($flight, 'Flight Retrieved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        return $this->onSuccess($flight, 'Flight Retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $data = $request->all();

        // Validate request data
         $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->onError(400,'Validation Error.',$errors);
        }

        // Update flight
        $flight->update($data);

        return $this->onSuccess($flight, 'Flight Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        $flight->delete(); // Delete the specific flight data
        return $this->onSuccess($flight, 'Flight Deleted');
    }
}
