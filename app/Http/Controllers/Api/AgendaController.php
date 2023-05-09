<?php

namespace App\Http\Controllers\Api;

use App\AgendaItem;
use App\AgendaItemCategorie;
use App\Http\Controllers\Controller;
use App\Services\AgendaApplicationFormService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AgendaController extends Controller
{
    public function getAgenda(Request $request){
        $agendaItemQeury = AgendaItem::query()
            ->with(
                'agendaItemShortDescription',
                'getApplicationForm',
                'getApplicationFormResponses',
                'agendaItemCategory',
                'agendaItemCategory.categorieName'
            );
        $limit = $request->has('limit')? $request->get('limit'): 9;
        $start = $request->has('start')? $request->get('start') : 0;

        //add parameters if there set in the url
        if($request->has('category')){
            $agendaItemQeury->where('category','=', intval($request->get('category')));
        }
        if($request->has('startDate')){
            $startDate = Carbon::createFromFormat('d-m-Y', $request->get('startDate'))->setTime(0, 0, 0);
            $agendaItemQeury
                ->where(function ($query) use ($startDate) {
                    $query
                        ->where("startDate",'>=',$startDate)
                        ->orWhere("endDate",'>=',$startDate);
                });
        }
        if($request->has('endDate')){
            $endDate = Carbon::createFromFormat('d-m-Y', $request->get('endDate'))->setTime(0, 0, 0);
            $agendaItemQeury->where("startDate",'<=',$endDate);
        }

        $agendaItems_compleet = $agendaItemQeury->orderBy('startDate', 'asc')->get();
        $agendaItems = array();
        
        //service to get the responses for an agenda item
        $agendaApplicationFormService = new AgendaApplicationFormService();
        
       
        for($i= $start; $i < ($start + $limit >= count($agendaItems_compleet)? count($agendaItems_compleet) : $start + $limit); $i++){
            $agendaItem = $agendaItems_compleet[$i];
            //check if the currently signed in user is signed up for the agenda item
            $currentUserSignedUp = false;
            if($agendaItem->application_form_id != null){
                if($agendaItem->canRegister()) {
                    foreach ($agendaApplicationFormService->getRegisteredUsers($agendaItem)['userdata'] as $user){
                        if($user->id == Auth::id()) {
                            $currentUserSignedUp = true;
                        }
                    }
                }
            }
            
            array_push($agendaItems,[
                "id"    => $agendaItem->id,
                "title" => $agendaItem->agendaItemTitle->text(),
                "thumbnail" => $agendaItem->getImageUrl(),
                "startDate" => Carbon::parse($agendaItem->startDate)->format('d M'),
                "endDate" => $agendaItem->endDate,
                "full_startDate" => $agendaItem->startDate,
                "category" => $agendaItem->agendaItemCategory->categorieName->text(),
                "text" => $agendaItem->agendaItemShortDescription->text(),
                "formId" => $agendaItem->getApplicationForm,
                "canRegister" => $agendaItem->canRegister(),
                "application_form_id" => $agendaItem->application_form_id,
                "amountOfPeopleRegisterd" => count($agendaItem->getApplicationFormResponses),
                "currentUserSignedUp" => $currentUserSignedUp
                ]);
        }
        return [
            "agendaItemCount" => count($agendaItems_compleet),
            "agendaItems" => $agendaItems
        ];
    }

    public function getCategories(){
        $categories = [];
        foreach(AgendaItemCategorie::with('categorieName')->get() as $category){
            array_push($categories,[
                'id' => $category->id,
                'name' => $category->categorieName->text()
            ]);
        }
        return response()
            ->json($categories);
    }
}
