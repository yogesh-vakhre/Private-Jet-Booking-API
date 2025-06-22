<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiHelpers;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
     use ApiHelpers; // Using the apiHelpers Trait

    /**
     * Display a listing of the resource.
     *
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

        // Query Booking
        $query = Booking::query();
        $query->with('user','flight');
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

        $query = $query->where('user_id', auth()->id());

        // Fetch Booking
        $booking = $query->get();

        // Return response

        return $this->onSuccess([
                'booking' => $booking,
                'totalCount' => $totalCount,
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy,
                'sortDirection' => $sortDirection,
            ],
            'Booking All Retrieved'
        );
    }

    /**
     * Display a booking report of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReport() {
        return [
            'total_bookings' => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'pending' => Booking::where('status', 'pending')->count()
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid',
            'flight_id' => 'required|uuid',
            'status' => 'required|in:confirmed,cancelled,pending',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
           $errors = $validator->errors();
           return $this->onError(404,'Validation Error.',$errors);
        }

        // Return errors if flight not found error occur.
        $flight = Flight::find($request->healthcare_professional_id);
        if (empty($flight)) {
            return $this->onError(404,'Flight not found');
        }
        // Return errors if user not found error occur.
        $user = User::find($request->user_id);
        if (empty($user )) {
            return $this->onError(404,'User not found');
        }
        $task = Booking::create($request->all());

        return $this->onSuccess($task, 'Booking Created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return $this->onSuccess($booking, 'Booking Retrieved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return $this->onSuccess($booking, 'Booking Retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->all();

        // Validate request data
         $validator = Validator::make($request->all(), [
            'status' => 'required|in:confirmed,cancelled,pending',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->onError(400,'Validation Error.',$errors);
        }

        // Update booking
        $booking->update($data);

        return $this->onSuccess($booking, 'Booking Status Updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete(); // Delete the specific booking data
        return $this->onSuccess($booking, 'Booking Deleted');
    }
}
