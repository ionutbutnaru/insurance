<?php

namespace App\Http\Controllers;

use App\Constants\CnpRulesConstants;
use App\Helpers\CnpValidator;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class OfferController extends Controller
{
    /**
     * index
     * Show users's the offers
     * @return View
     */
    public function index(): View
    {
        $offers = Offer::select('id', 'insurance_bonus', 'created_at')
            ->where('admin_id', auth()->user()->id)
            ->with('user')
            ->paginate(5);
        return view('offers.offers_list', ['offers' => $offers]);
    }

    /**
     * getCreate
     * Get create offer view
     * @return View
     */
    public function getCreate(): View
    {
        $validationErrors = [];
        return view('offers.create_offer', compact('validationErrors'));
    }

    /**
     * createOffer
     * Validate data
     * Create new offer in db
     * @param  Request $request
     * @return RedirectResponse
     */
    public function createOffer(Request $request): RedirectResponse
    {

        $request->validate([
            'insurance_bonus' => ['required', 'numeric'],
            'insured_name' => ['required', 'string'],
            'insured_cnp' => ['required', 'numeric', 'digits:13', Rule::unique('offers', 'insured_cnp')],
        ]);

        if ($return  = $this->validateCnpInDetail($request, 'create_offer')) {
            return $return;
        }

        $offer = Offer::create([
            'insurance_bonus' => $request->insurance_bonus,
            'insured_name' => $request->insured_name,
            'insured_cnp' => $request->insured_cnp,
            'admin_id' => Auth::user()->id,
        ]);

        if (!$offer) {
            return redirect()
                ->back()
                ->with('error', 'Offer could not be found');
        }

        return redirect()->route('offers.offers_list')->with('success', 'Offer created successfully.');
    }

    /**
     * validateCnpInDetail
     * Check if any error received from validation helper
     * Return back to view when error found
     * @param  Request $request
     * @param  string $view
     * @param  Offer $offer
     * @return
     */
    public function validateCnpInDetail(Request $request, $view, $offer = null)
    {
        $cnp = $request->insured_cnp;
        $cnpValidationResults = CnpValidator::validateCnp($cnp);

        $validationErrors = [];
        foreach ($cnpValidationResults as $field => $error) {
            if ($error) {
                $validationErrors[$field] = $error;
            }
        }
        if (!empty($validationErrors)) {
            return view('offers.' . $view, compact('validationErrors', 'offer'));
        }
    }

    /**
     * getDetails
     *  Return offer details in new view if found
     * @param  integer $offerId
     * @return
     */
    public function getDetails($offerId)
    {
        $authId =  auth()->user()->id;
        $offer = Offer::where('id', $offerId)
            ->where('admin_id', $authId)
            ->first();

        if (!$offer) {
            return redirect()
                ->back()
                ->with('error', 'Offer could not be found');
        }
        return view('offers.offer_details', compact('offer'));
    }

    /**
     * getUpdate
     * Return view for update offer
     * @param  mixed $offerId
     * @return
     */
    public function getUpdate($offerId)
    {

        $authId =  auth()->user()->id;
        $offer = Offer::where('id', $offerId)
            ->where('admin_id', $authId)
            ->first();

        if (!$offer) {
            return redirect()
                ->back()
                ->with('error', 'Offer could not be found');
        }

        $validationErrors = [];
        return view('offers.update_offer', compact('validationErrors', 'offer'));
    }


    /**
     * updateOffer
     * Validate request data
     * Update offer in db
     * @param  mixed $request
     * @param  mixed $id
     * @return
     */
    public function updateOffer(Request $request, $id)
    {

        $validatedData =  $request->validate([
            'insurance_bonus' => ['required', 'numeric'],
            'insured_name' => ['required', 'string'],
            'insured_cnp' => ['required', 'numeric', 'digits:13', Rule::unique('offers', 'insured_cnp')->ignore($id)],
        ]);

        $authId =  auth()->user()->id;
        $offer = Offer::where('id', $id)
            ->where('admin_id', $authId)
            ->first();

        if ($return = $this->validateCnpInDetail($request, 'update_offer', $offer)) {
            return $return;
        }

        $offer->update($validatedData);

        return redirect()->route('offers.offers_list')
            ->with('success', 'Offer updated successfully.');
    }

    /**
     * deleteOffer
     * Delete offer if found
     * @param  mixed $id
     * @return
     */
    public function deleteOffer($id)
    {

        $authId =  auth()->user()->id;
        $offer = Offer::where('id', $id)
            ->where('admin_id', $authId)
            ->first();

        if (!$offer) {
            return redirect()
                ->back()
                ->with('error', 'Offer could not be found');
        }

        $offer->delete();

        return redirect()->route('offers.offers_list')
            ->with('success', 'Offer deleted successfully.');
    }
}
