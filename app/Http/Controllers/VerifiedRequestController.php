<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\VerifiedRequestSaveRequest;
use App\VerifiedRequest;
use Illuminate\Http\Request;

class VerifiedRequestController extends Controller
{
    public function index()
    {
        return VerifiedRequest::with(['user','campaign'])->get();
    }

    public function show($id)
    {
        return VerifiedRequest::with(['user','campaign'])->findOrFail($id);
    }

    public function store(VerifiedRequestSaveRequest $request)
    {
        $verifiedRequest = new VerifiedRequest();

        $verifiedRequest->user_id = \Auth::user()->id;
        $verifiedRequest->campaign_id = $request->json('campaign_id');
        $verifiedRequest->entity = $request->json('entity');

        $requestExists = VerifiedRequest::where('entity', $verifiedRequest->entity)->where('campaign_id', $verifiedRequest->campaign_id)->first();
        if($requestExists)
            return response(['errors' => ['message' =>'Request for this campaign and asset exists already']],422);

         $verifiedRequest->save();

        return response(['message'=> 'Successfully'], 200);
    }

    public function directApprove(Request $request)
    {
        $entity = $request->json('entity');
        $campaign = Campaign::findOrFail($request->json('campaign_id'));

        if($entity == 'SMS')
            $campaign->sms_verified = false;

        if($entity== 'CALL')
            $campaign->call_verified = false;

        if($entity == 'EMAIL')
            $campaign->email_verified = false;

        if($entity == 'CAMPAIGN')
        {
            $campaign->sms_verified = false;
            $campaign->call_verified = false;
            $campaign->email_verified = false;
        }
        $campaign->campaign_verified = false;
        $campaign->update();
    }
    public function approve($id)
    {
        $flag = true;
        $verifiedRequest = VerifiedRequest::findOrFail($id);

        $campaign = Campaign::findOrFail($verifiedRequest->campaign_id);
        if($verifiedRequest->entity == 'SMS')
            $campaign->sms_verified = false;

        if($verifiedRequest->entity == 'CALL')
            $campaign->call_verified = false;

        if($verifiedRequest->entity == 'EMAIL')
            $campaign->email_verified = false;

        if($verifiedRequest->entity == 'CAMPAIGN')
        {
            $campaign->sms_verified = false;
            $campaign->call_verified = false;
            $campaign->email_verified = false;
            $flag = true;
        }
        $campaign->campaign_verified = false;
        $campaign->update();

        if($flag)
            VerifiedRequest::where('campaign_id', $verifiedRequest->campaign_id)->delete();
        else
            $this->destroy($id);
        return response(['message' => 'Successfully'], 200);
    }

    public function destroy($id)
    {
        $verifiedRequest = VerifiedRequest::findOrFail($id);
        $verifiedRequest->delete();
    }

}
