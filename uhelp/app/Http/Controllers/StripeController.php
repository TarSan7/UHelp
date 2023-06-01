<?php

namespace app\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName'   => 'required',
            'cardNumber' => 'required',
            'month'      => 'required',
            'year'       => 'required',
            'cvv'        => 'required',
            'sum'        => 'required',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('danger', );
            return new JsonResponse($validator->errors(), 304);
        }

        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            $request->session()->flash('danger', $token['error']);
        }
        if (empty($token['id'])) {
            return new JsonResponse(['message' => 'Payment failed'], 304);
        }

        $charge = $this->createCharge($token['id'], $request->get('sum'));

        if (!$charge['error'] && $charge['status'] == 'succeeded') {
            return new JsonResponse(['message' => 'Success'], 200);
        } else {
            return new JsonResponse(['danger' => 'Payment failed.'], 304);
        }
    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }
}
