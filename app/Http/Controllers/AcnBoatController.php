<?php

namespace App\Http\Controllers;

use App\Models\web\AcnBoat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcnBoatController extends Controller
{
    static public function getAllBoat() {
        return view ('propose_slot', ["boats" => AcnBoat::all() ]);
    }

    /**
     * 
     *
     * @param $BoatNum num from the specific boat
     * @return the capacity from the boat
     */
    static public function getBoatCapacity($BoatNum) {
        $capacity = DB::table('ACN_BOAT')
            -> select('BOA_CAPACITY')
            -> where('BOA_NUM_BOAT', '=', $BoatNum)
            -> get();
        
        $capacity = (array) $capacity[0];
        return $capacity['BOA_CAPACITY'];
    }

    /**
     *
     * @return the max capacity from all the boat
     */
    static public function getMaxCapacity() {
        $capacity = DB::table('ACN_BOAT')
            -> selectRaw('max(BOA_CAPACITY) as max')
            -> get();
        
        $capacity = (array) $capacity[0];
        return $capacity['max'];
    }

    /**
     *
     * @param $BoatNum num from the specific boat
     * @return the name from the boat
     */
    static public function getBoatName($BoatNum) {
        $capacity = DB::table('ACN_BOAT')
            -> select('BOA_NAME')
            -> where('BOA_NUM_BOAT', '=', $BoatNum)
            -> get();
        
        $capacity = (array) $capacity[0];
        return $capacity['BOA_NAME'];
    }

    /**
     * 
     *
     * @param Request $request 
     * @return void
     */
    static public function create(Request $request) {
        $errors = array();
        $nameAlreadyExist = AcnBoat::where("BOA_NAME", "=", strtoupper($request->boa_name))->exists();
        if ($nameAlreadyExist) {
            $errors["name"] = "Le nom donné est déjà existant.";
        }
        if ($request->boa_capacity < 4) {
            $errors["number"] = "La capacité doit être supérieure ou égale à 4.";
        }
        if (empty($request->boa_name) || empty($request->boa_capacity)) {
            $errors["empty_entry"] = "Tous les champs doivent êtres remplis.";
        }
        if (count($errors) != 0) return back()->withErrors($errors);
        $boat = new AcnBoat;
        $boat->BOA_NAME = strtoupper($request->boa_name);
        $boat->BOA_CAPACITY = $request->boa_capacity;
        $boat->save();
        return redirect(route("managerPanel"));
    }

    static public function delete($boatId) {
        $boat = AcnBoat::find($boatId);
        $boat->BOA_DELETED = 1;
        $boat->save();
    }

    static public function update(Request $request, $boatId) {
        $boat = AcnBoat::find($boatId);
        $errors = array();
        $nameAlreadyExist = AcnBoat::where("BOA_NAME", "=", strtoupper($request->boa_name))->where("BOA_NUM_BOAT", "!=", $boatId)->exists();
        if ($nameAlreadyExist) {
            $errors["name"] = "Le nom donné est déjà existant.";
        }
        if ($request->boa_capacity < 4) {
            $errors["number"] = "La capacité doit être supérieure ou égale à 4.";
        }
        if (empty($request->boa_name) || empty($request->boa_capacity)) {
            $errors["empty_entry"] = "Tous les champs doivent êtres remplis.";
        }
        if (count($errors) != 0) return back()->withErrors($errors);
        $boat->BOA_NAME = strtoupper($request->boa_name);
        $boat->BOA_CAPACITY = $request->boa_capacity;
        $boat->save();
        return redirect(route("managerPanel"));
    }

    static public function getBoatUpdateView($boatId) {
        $boat = AcnBoat::find($boatId);
        return view("manager/updateBoat", ["boat" => $boat]);
    }
}
