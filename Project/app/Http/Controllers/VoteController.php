<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Battle;
use App\Vote;

class VoteController extends Controller
{
    public function destroy ($id) {

        $battle_id = Battle::where('hosting_id', $id)->value('id');
        if (Vote::where('battle_id', $battle_id)->exists()) {
            $votes = Vote::where('battle_id', $battle_id)->get();
            foreach ($votes as $vote) {
                $vote->delete();
            }
        }

    }
}
