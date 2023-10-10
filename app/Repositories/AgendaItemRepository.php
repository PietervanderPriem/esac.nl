<?php

namespace App\Repositories;

use App\AgendaItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgendaItemRepository implements IRepository
{
    public function create(array $data)
    {
        $agendaItem = new AgendaItem($data);
        $subscription_endDate = new \DateTime($data['subscription_endDate']);

        $agendaItem->startDate = Carbon::createFromFormat('d-m-Y H:i', $data['startDate'])->format('Y-m-d H:i:s');
        $agendaItem->endDate = Carbon::createFromFormat('d-m-Y H:i', $data['endDate'])->format('Y-m-d H:i:s');

        if ($data['applicationForm'] != 0) {
            $agendaItem->subscription_endDate = Carbon::parse($subscription_endDate)->format('Y-m-d H:i:s');
            $agendaItem->application_form_id = $data['applicationForm'];
        } else {
            $agendaItem->subscription_endDate = null;
            $agendaItem->application_form_id = null;
        }

        $agendaItem->image_url = "";
        $agendaItem->createdBy = Auth::user()->id;
        $agendaItem->climbing_activity = array_key_exists('climbing_activity', $data);
        $agendaItem->save();

        return $agendaItem;
    }

    public function update($id, array $data)
    {
        $agendaItem = $this->find($id);

        $agendaItem->category = $data['category'];
        $agendaItem->startDate = Carbon::createFromFormat('d-m-Y H:i', $data['startDate'])->format('Y-m-d H:i:s');
        $agendaItem->endDate = Carbon::createFromFormat('d-m-Y H:i', $data['endDate'])->format('Y-m-d H:i:s');

        if ($data['applicationForm'] != 0) {
            $agendaItem->subscription_endDate = Carbon::createFromFormat('d-m-Y H:i', $data['subscription_endDate'])->format('Y-m-d H:i:s');
            $agendaItem->application_form_id = $data['applicationForm'];
        } else {
            $agendaItem->subscription_endDate = null;
            $agendaItem->application_form_id = null;
        }

        $agendaItem->climbing_activity = array_key_exists('climbing_activity', $data);
        $agendaItem->save();

        return $agendaItem;
    }

    public function delete($id)
    {
        $agendaItem = $this->find($id);
        $agendaItem->delete();

        if ($agendaItem->image_url != "") {
            Storage::delete('public/' . $agendaItem->image_url);
        }
    }

    public function find($id, $columns = array('*'))
    {
        return $this->findBy('id', $id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return AgendaItem::query()->where($field, '=', $value)->first($columns);
    }

    public function all($columns = array('*'))
    {
        return AgendaItem::all($columns);
    }

    public function copy(AgendaItem $agendaItem): AgendaItem
    {
        $newAgendaItem = $agendaItem->replicate();
        $newAgendaItem->createdBy = Auth::user()->id;
        $newAgendaItem->save();

        if ($agendaItem->image_url !== null && $agendaItem->image_url !== "") {
            $oldPath = $agendaItem->image_url;
            $newPath = str_replace($agendaItem->id, $newAgendaItem->id, $oldPath);
            Storage::disk('public')->copy($oldPath, $newPath);
            $newAgendaItem->image_url = $newPath;
            $newAgendaItem->save();
        }

        return $newAgendaItem;
    }

    public function getFirstXItems($limit)
    {
        return AgendaItem::query()
            ->with('getApplicationFormResponses')
            ->whereDate('startDate', '>=', Carbon::now())
            ->orderBy('startDate', 'ASC')
            ->take($limit)
            ->get();
    }
}
