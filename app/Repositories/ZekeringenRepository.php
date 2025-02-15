<?php
/**
 * Created by PhpStorm.
 * User: IA02UI
 * Date: 15-6-2017
 * Time: 20:39
 */

namespace App\Repositories;


use App\Zekering;
use Illuminate\Support\Facades\Auth;

class ZekeringenRepository implements IRepository
{

    public function create(array $data)
    {
        $zekering = new Zekering();
        $zekering->text = $data["text"];
        $zekering->createdBy = Auth::user()->id;
        $zekering->score = 1;
        $zekering->save();

        if(array_key_exists('parent',$data)) {
            $zekering->parent_id = $data["parent"];
            $zekering->has_parent = True;
            $zekering->save();
        } else {
            $zekeringId = $zekering->id;
            $zekering->parent_id = $zekeringId;
            $zekering->has_parent = False;
            $zekering->save();
        }
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        Zekering::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        // TODO: Implement find() method.
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return Zekering::where($field, '=',$value)->orderBy('id', 'desc')->get($columns);
    }

    public function all($columns = array('*'))
    {
        return Zekering::query()->orderBy('parent_id', 'desc')->get();
    }

    public function getChildZekeringen($parentid){
        return Zekering::query()->where('parent_id','=',$parentid)->where('id', '!=',$parentid)->orderBy('id', 'asc')->get();
    }
}