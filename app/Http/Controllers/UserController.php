<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GameStat;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $users = $query->paginate(10);

        return Inertia::render('User/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    public function editStats(Request $request, User $user)
    {
        $group_id = (int) $request->input('group');
        $stats = GameStat::where('user_id', $user->id)->where('group_id', $group_id)->get();
        return Inertia::render('User/Stats/Edit', ['user' => $user, 'stats' => $stats, 'group_id' => $group_id]);
    }

    public function updateStats(Request $request, User $user)
    {
        $request->validate([
            'date' => 'required|date',
            'opponent' => 'required|string',
            'at_bats' => 'required|integer',
            'hits' => 'required|integer',
            'pitches' => 'required|integer',
            'walks' => 'required|integer',
            'batting_average' => 'required|numeric',
            'group_id' => 'required|exists:groups,id',
        ]);

        $stats = new GameStat($request->all());
        $stats->user_id = $user->id;
        $stats->save();

        return redirect()->route('groups.show', $stats->group_id);
    }
}