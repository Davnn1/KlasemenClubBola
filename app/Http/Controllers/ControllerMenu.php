<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;

class ControllerMenu extends Controller
{
    public function index()
    {
        return view('menu');
    }

    public function club()
    {
        return view('menu.inputclub');
    }

    public function process_club(Request $req)
    {
        $nama = $req->club;
        $asal = $req->kota;

        try {
            DB::table('club')->insert([
                'nama_club' => $nama,
                'asal_club' => $asal,
            ]);
            Session::flash('success');
        } catch (QueryException $ex) {
            Session::flash('failed');
        }
        return redirect()->action([ControllerMenu::class, 'club']);
    }

    public function match()
    {
        $clubs = DB::table('club')->get();
        return view('menu.inputmatch', compact('clubs'));
    }

    public function process_match(Request $request)
    {
        // Validasi form
        $request->validate([
            'matches' => 'required|array|min:1',
            'matches.*.klub1' => 'required',
            'matches.*.klub2' => 'required',
            'matches.*.score1' => 'required|integer',
            'matches.*.score2' => 'required|integer',
        ]);

        $matches = $request->matches;

        try {
            foreach ($matches as $match) {
                $klub1 = $match['klub1'];
                $klub2 = $match['klub2'];
                $score1 = $match['score1'];
                $score2 = $match['score2'];

                // Cek apakah data pertandingan sudah ada
                $existingMatch = DB::table('matches')
                    ->where('klub1', $klub1)
                    ->where('klub2', $klub2)
                    ->first();

                if ($existingMatch) {
                    Session::flash('failed', 'Data pertandingan sudah ada!');
                    return redirect()->action([ControllerMenu::class, 'match']);
                }

                // Simpan data pertandingan
                DB::table('matches')->insert([
                    'klub1' => $klub1,
                    'klub2' => $klub2,
                    'score1' => $score1,
                    'score2' => $score2,
                ]);

                // Update klasemen
                $this->updateKlasemen($klub1, $klub2, $score1, $score2);
            }

            Session::flash('success', 'Data pertandingan berhasil disimpan!');
            return redirect()->action([ControllerMenu::class, 'match']);
        } catch (\Exception $ex) {
            Session::flash('failed', 'Gagal menyimpan data pertandingan!');
            return redirect()->action([ControllerMenu::class, 'match']);
        }
    }
    

    public function klasemen()
    {
        $klasemen = DB::table('klasemen')->orderBy('point', 'desc')->get();
        return view('menu.klasemen', compact('klasemen'));
    }

    private function updateKlasemen($klub1, $klub2, $score1, $score2)
    {
        // Update klub 1
        $klub1Data = DB::table('klasemen')->where('klub', $klub1)->first();
        if (!$klub1Data) {
            DB::table('klasemen')->insert([
                'klub' => $klub1,
                'main' => 1,
                'menang' => ($score1 > $score2) ? 1 : 0,
                'seri' => ($score1 === $score2) ? 1 : 0,
                'kalah' => ($score1 < $score2) ? 1 : 0,
                'goal_menang' => $score1,
                'goal_kalah' => $score2,
                'point' => ($score1 > $score2) ? 3 : (($score1 === $score2) ? 1 : 0),
            ]);
        } else {
            DB::table('klasemen')->where('klub', $klub1)->update([
                'main' => $klub1Data->main + 1,
                'menang' => $klub1Data->menang + (($score1 > $score2) ? 1 : 0),
                'seri' => $klub1Data->seri + (($score1 === $score2) ? 1 : 0),
                'kalah' => $klub1Data->kalah + (($score1 < $score2) ? 1 : 0),
                'goal_menang' => $klub1Data->goal_menang + $score1,
                'goal_kalah' => $klub1Data->goal_kalah + $score2,
                'point' => $klub1Data->point + (($score1 > $score2) ? 3 : (($score1 === $score2) ? 1 : 0)),
            ]);
        }

        // Update klub 2
        $klub2Data = DB::table('klasemen')->where('klub', $klub2)->first();
        if (!$klub2Data) {
            DB::table('klasemen')->insert([
                'klub' => $klub2,
                'main' => 1,
                'menang' => ($score2 > $score1) ? 1 : 0,
                'seri' => ($score2 === $score1) ? 1 : 0,
                'kalah' => ($score2 < $score1) ? 1 : 0,
                'goal_menang' => $score2,
                'goal_kalah' => $score1,
                'point' => ($score2 > $score1) ? 3 : (($score2 === $score1) ? 1 : 0),
            ]);
        } else {
            DB::table('klasemen')->where('klub', $klub2)->update([
                'main' => $klub2Data->main + 1,
                'menang' => $klub2Data->menang + (($score2 > $score1) ? 1 : 0),
                'seri' => $klub2Data->seri + (($score2 === $score1) ? 1 : 0),
                'kalah' => $klub2Data->kalah + (($score2 < $score1) ? 1 : 0),
                'goal_menang' => $klub2Data->goal_menang + $score2,
                'goal_kalah' => $klub2Data->goal_kalah + $score1,
                'point' => $klub2Data->point + (($score2 > $score1) ? 3 : (($score2 === $score1) ? 1 : 0)),
            ]);
        }
    }
}
