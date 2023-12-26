<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\ReservationPremade;
use App\Models\ReservationSelection;
use App\Models\ServicePackage;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function showForm($packageId)
    {
        // Fetch menu selections to populate dropdowns
        $menuSelections = [
            'pork' => Menu::where('menu_selection_id', 1)->get(),
            'chicken' => Menu::where('menu_selection_id', 3)->get(),
            'vegetable' => Menu::where('menu_selection_id', 7)->get(),
            'fish' => Menu::where('menu_selection_id', 4)->get(),
            'seafood' => Menu::where('menu_selection_id', 5)->get(),
            'pasta' => Menu::where('menu_selection_id', 6)->get(),
            'dessert' => Menu::where('menu_selection_id', 8)->get(),
            'drink' => Menu::where('menu_selection_id', 9)->get(),
            'beef' => Menu::where('menu_selection_id', 2)->get(),
            
        ];

        $specificPackage = ServicePackage::findOrFail($packageId);

        return view('user.reservations.premade', compact('menuSelections', 'specificPackage'));
    }

    public function submitForm(Request $request)
    {

        $request->validate([

            'celebrant_name' => 'required|string',
            'celebrant_age' => 'required|numeric|min:0',
            'event_theme' => 'required|string',
            'celebrant_gender' => 'required|in:Male,Female',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'venue_address' => 'required|string',
            'agree_terms' => 'required|boolean',
            'pork_menu' => 'required|exists:menus,id',
            'beef_menu' => 'required|exists:menus,id',
            'chicken_menu' => 'required|exists:menus,id',
            'fish_menu' => 'required|exists:menus,id',
            'seafood_menu' => 'required|exists:menus,id',
            'vegetable_menu' => 'required|exists:menus,id',
            'dessert_menu' => 'required|exists:menus,id',
            'drink_menu' => 'required|exists:menus,id',
            'pasta_menu' => 'required|exists:menus,id',
            'agree_terms' => 'required|boolean|accepted',


        ],[
            'agree_terms.accepted' => 'Please check the terms and conditions.',
        ] );

        $packageId = $request->input('selected_package');

        $reservation = Auth::user()->reservations()->create([
            'celebrant_name' => $request->input('celebrant_name'),
            'celebrant_age' => $request->input('celebrant_age'),
            'event_theme' => $request->input('event_theme'),
            'celebrant_gender' => $request->input('celebrant_gender'),
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time'),
            'venue_address' => $request->input('venue_address'),
            'agree_terms' => $request->input('agree_terms'),
            'pork_menu_id' => $request->input('pork_menu'),
            'beef_menu_id' => $request->input('beef_menu'),
            'chicken_menu_id' => $request->input('chicken_menu'),
            'fish_menu_id' => $request->input('fish_menu'),
            'seafood_menu_id' => $request->input('seafood_menu'),
            'veggies_menu_id' => $request->input('vegetable_menu'),
            'dessert_menu_id' => $request->input('dessert_menu'),
            'drink_menu_id' => $request->input('drink_menu'),
            'pasta_menu_id' => $request->input('pasta_menu'),


        ]);

        $reservation->selections()->create([
            'choice' => 'premade',
        ]);

        $reservation->premades()->create([
            'package_id' => $packageId,
        ]);

        // Redirect to the summary page
        return redirect()->route('user.reservations.p_summary', $reservation->id);
    }

    public function showSummary($reservationId)
    {
        $reservations = Reservation::with('premades.servicePackage', 'user')->findOrFail($reservationId);
        

        return view('user.reservations.p_summary', compact('reservations'));
    }
}
