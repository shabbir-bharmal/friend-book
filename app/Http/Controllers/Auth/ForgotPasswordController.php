<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        try {
            $field = filter_var($request->input('email')) ? 'email' : 'phone_number';
            $user = User::where($field, $request->get('email'))->first();
            if(empty($user)) {
                return response()->json(['success' => false, 'message' => "User not found."], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                ['email'=>$user->email]
            );

            return $response == Password::RESET_LINK_SENT
                ? response()->json(['success' => true, 'message' => "We have e-mailed your password reset link!"], JsonResponse::HTTP_OK)
                : response()->json(['success' => false, 'message' => $response], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);


        } catch (\Exception $e) {
            response()->json(['success' => false, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
