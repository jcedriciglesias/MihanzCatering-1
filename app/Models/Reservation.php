<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'celebrant_name', 'celebrant_age', 'event_theme', 'event_date', 'event_time', 'venue_address', 'celebrant_gender', 'agree_terms', 'pork_menu_id', 'chicken_menu_id', 'veggies_menu_id',
        'beef_menu_id', 'pasta_menu_id', 'fish_menu_id', 'seafood_menu_id', 'dessert_menu_id', 'drink_menu_id',

    ];

    public function selections()
    {
        return $this->hasMany(ReservationSelection::class);
    }

    public function premades()
    {
        return $this->hasOne(ReservationPremade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function porkMenu()
{
    return $this->belongsTo(Menu::class, 'pork_menu_id');
}



public function beefMenu()
{
    return $this->belongsTo(Menu::class, 'beef_menu_id');
}

public function pastaMenu()
{
    return $this->belongsTo(Menu::class, 'pasta_menu_id');
}

public function chickenMenu()
{
    return $this->belongsTo(Menu::class, 'chicken_menu_id');
}

public function vegetableMenu()
{
    return $this->belongsTo(Menu::class, 'veggies_menu_id');
}

public function fishMenu()
{
    return $this->belongsTo(Menu::class, 'fish_menu_id');
}

public function seafoodMenu()
{
    return $this->belongsTo(Menu::class, 'seafood_menu_id');
}

public function dessertMenu()
{
    return $this->belongsTo(Menu::class, 'dessert_menu_id');
}

public function drinkMenu()
{
    return $this->belongsTo(Menu::class, 'drink_menu_id');
}


public function getMenuName($menuType)
{
    return $this->$menuType ? $this->$menuType->name : null;
}

}
