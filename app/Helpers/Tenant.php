<?php



// if (! function_exists('settings')) {
//     /**
//      * Gets the value from settings json file.
//      *
//      * @param  string  $key
//      * @param  mixed  $default
//      * @return mixed
//      */
//     function settings($key, $default = null)
//     {
//         $key = Valuestore::make(public_path('settings.json'))->get($key);

//         return $key ?? $default;
//     }
// }


if (! function_exists('getNumber')) {
    function getNumber()
    {
        return tenant()->subscription('main')->getFeatureByTag('leads_management')->value;
    }
}