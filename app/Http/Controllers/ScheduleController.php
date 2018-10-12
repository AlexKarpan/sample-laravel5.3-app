<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Http\Controllers\Controller;
use App\Booking;
use App\City;
use App\Customer;
use App\Cleaner;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a booking form.
     *
     * @return \Illuminate\View\View
     */	
	public function showForm()
	{
		// all cities sorted A to Z
		$cities = City::orderBy('name')->get()->pluck('name', 'id');

		return view('schedule', compact('cities'));
	}

    /**
     * Schedule a cleaning session or suggest available slots.
     * Create a Customer record if necessary.
     *
     * @param \App\Http\Requests\ScheduleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function schedule(ScheduleRequest $request)
	{
		// calculate start and end time for cleaning session

		$starts_at = Carbon::parse($request->date . ' ' . $request->time);

		if($starts_at <= Carbon::now()) {
			return redirect()
				->back()
				->withInput()
				->withErrors([
					'schedule' => "We can't schedule for the past",
				]);
		}

		// if 'not sure' or 'whole day', we assume it'll take the whole day
		if($request->duration == 0 || $request->duration == 24) {
			$ends_at = $starts_at->copy()->endOfDay();
		} else {
			$ends_at = $starts_at->copy()->addHours($request->duration);
		}


		// find an available cleaner

		$cleaner = $this->findAvailableCleaners($request->city_id, $starts_at, $ends_at);

		if(!$cleaner) {

			// check for other possible dates
			$deltas = [
				-72, -48, -24, 24, 48, 72,
			];

			$suggestions = [];

			foreach($deltas as $delta) {
				$new_starts_at = $starts_at->copy()->addHours($delta);
				if($new_starts_at <= Carbon::now()) {
					continue;
				}

				$new_ends_at = $ends_at->copy()->addHours($delta);

				$cleaner = $this->findAvailableCleaners(
					$request->city_id, 
					$new_starts_at, 
					$new_ends_at
				);

				if($cleaner) {
					$suggestions[] = $new_starts_at->format('Y-m-d');
				}
			}

			return redirect()
				->back()
				->withInput()
				->with('suggestions', $suggestions);
		}


		// find a customer by phone number or create a new record if not found

		$customer = Customer::firstOrCreate(
			[ 'phone_number' => $request->phone_number ],
			[
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
			]);


		// create a booking

		$booking = new Booking;
		$booking->customer_id = $customer->id;
		$booking->cleaner_id = $cleaner->id;
		$booking->city_id = $request->city_id;
		$booking->starts_at = $starts_at;
		$booking->ends_at = $ends_at;
		$booking->save();

		return redirect('/book/thank-you/' . $booking->id);
	}

    /**
     * Find an available cleaner.
     *
     * @param int $city_id
     * @param \Carbon\Carbon $starts_at
     * @param \Carbon\Carbon $ends_at
     *
     * @return \App\Cleaner
     */
	private function findAvailableCleaners($city_id, $starts_at, $ends_at)
	{
		// Laravel-way, fine as a sample, but should be rewritten in raw SQL for high load

		return Cleaner::whereHas('cities', function($query) use ($city_id) {
				$query->where('id', $city_id);
			})
			->whereDoesntHave('bookings', function($query) use ($starts_at, $ends_at) {
				$query->whereBetween('starts_at', [ $starts_at, $ends_at ])
					->orWhereBetween('ends_at', [ $starts_at, $ends_at ]);
			})
			->inRandomOrder()		// this needs to make it fair for cleaners
			->first();
	}

    /**
     * Show the 'thank you' page for the specified booking record.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
	public function showThankYouPage($id)
	{
		$booking = Booking::findOrFail($id);

		return view('thank-you', compact('booking'));
	}
	
}