<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{




    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user)
    {
        // Compruebe si la url es una url firmada válida
        if(! URL::hasValidSignature($request)){
            return response()->json(["errors"=> [
                "message" => "Enlace o firma de verificación no válida"
            ]], 422);
        }
        //Compruebe si el usuario ya ha verificado la cuenta
        if($user->hasVerifiedEmail()){
            return response()->json(["errors"=> [
                "message" => "Correo electrónico ya verificado."
            ]], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([ 'message' => 'Correo electrónico verificado con éxito.'], 200);
    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'email' => ['email']
        ]);

        $user = User::where('email',$request->email)->first();
        //$user = $this->users->findWhereFirst('cedula', $request->cedula);

        if(! $user){
            return response()->json(["errors"=>[
                "cedula" => "No se pudo encontrar ningún usuario con el correo electrónico."
            ]], 422);
        }

        if($user->hasVerifiedEmail()){
            return response()->json(["errors"=> [
                "message" => "Correo electrónico ya verificado."
            ]], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => "Enlace de verificación reenviado."]);
    }
}
