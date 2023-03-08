<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function changeLanguage($locale){
             
             
        App::setLocale($locale);
        session()->put('locale', $locale);
        //dd(session()->get('locale'));
        $prev_url=str_replace(url('/'), '', url()->previous());
        //dd($prev_url);
        if($prev_url=='/serviceproviders/add-serviceprovider2'||$prev_url=='/serviceproviders/add-serviceprovider3')
        {
        	//return redirect()->action('Admin\Serviceprovider\ServiceproviderController@create2');
        	return redirect()->route('serviceproviders.create');
        }

        if($prev_url=='property/add_information'||$prev_url=='/property/add_structure_details'||$prev_url=='/property/add_property_confirmation'||$prev_url=='/property/add-property-complex2')
        {
        	//return redirect()->action('Admin\Serviceprovider\ServiceproviderController@create2');
        	return redirect()->route('property.list');
        }
        
        else
        {
        	return redirect()->back();
        }
        //return redirect()->back();

    }
}
