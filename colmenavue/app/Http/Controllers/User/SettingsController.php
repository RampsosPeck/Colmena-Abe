<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\CheckSamePassword;
use App\Rules\MatchOldPassword;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function updateProfile(Request $request)
    {
    	$user = auth()->user();

    	$this->validate($request, [
    		'about' => ['required','string','min:20'],
    		'formatted_address' => ['required'],
    		'location.latitude' => ['required','numeric','min:-90','max:90'],
    		'location.longitude' => ['required','numeric','min:-180','max:180']
    	]);

    	$location = new Point($request->location['latitude'], $request->location['longitude']);
    	$user->update([
    		'formatted_address' => $request->formatted_address,
    		'location' => $location,
    		'about' => $request->about
    	]);

    	return new UserResource($user);

    }

    public function updatePassword(Request $request)
    {
    	// Current password
    	// new password
    	// password confirmation
    	$this->validate($request, [
    		'current_password' => ['required', new MatchOldPassword],
    		'password' => ['required', 'confirmed', 'min:6', new CheckSamePassword ]
    	]);

    	$request->user()->update([
    		'password' => bcrypt($request->password)
    	]);

    	return response()->json(['message'=>'Contraseña actualizada correctamente.'], 200);

    }
}
