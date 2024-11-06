<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Group;
use App\Models\User;
use App\Models\GameStat;
use App\Models\JoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $groups = $query->paginate(10);
        $userGroups = auth()->user()->groups->pluck('id')->toArray(); // ユーザーが参加しているグループのIDリスト

        return Inertia::render('Group/Index', [
            'groups' => $groups,
            'filters' => $request->only('search'),
            'userGroups' => $userGroups, // ビューに渡す
        ]);
    }

    public function create()
    {
        return Inertia::render('Group/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'admin_id' => auth()->id(), // 管理者として保存
        ]);

        $group->users()->attach(auth()->id());

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function join()
    {
        return Inertia::render('Group/Join');
    }

    public function requestJoin(Request $request)
    {
        $request->validate([
            'group_name' => 'required|exists:groups,name',
        ]);

        $group = Group::where('name', $request->group_name)->firstOrFail();

        JoinRequest::create([
            'user_id' => auth()->id(),
            'group_id' => $group->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Join request sent successfully.');
    }

    public function approveJoin(Request $request, JoinRequest $joinRequest)
    {
        // 参加リクエストの承認を行う
        $joinRequest->group->users()->attach($joinRequest->user_id);
        $joinRequest->delete();

        return redirect()->route('dashboard')->with('success', 'Join request approved successfully.');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $joinRequests = JoinRequest::whereHas('group', function ($query) use ($user) {
            $query->where('admin_id', $user->id);
        })->with('user', 'group')->get();

        // スタッツを入力された順に取得
        $userStats = GameStat::where('user_id', $user->id)->orderBy('created_at', 'asc')->get();

        return Inertia::render('Dashboard', [
            'joinRequests' => $joinRequests,
            'userStats' => $userStats,
        ]);
    }

    public function show(Group $group)
    {
        $isAdmin = auth()->id() === $group->admin_id;
        return Inertia::render('Group/Show', [
            'group' => $group,
            'users' => $group->users,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function destroy(Group $group)
    {
        // 管理者のみが削除できるようにする
        if (Auth::id() !== $group->admin_id) {
            return redirect()->route('groups.index')->with('error', 'You do not have permission to delete this group.');
        }

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }

    public function removeUser(Request $request, Group $group, User $user)
    {
        // 管理者のみが削除できるようにする
        if (Auth::id() !== $group->admin_id) {
            return redirect()->route('groups.show', $group->id)->with('error', 'You do not have permission to remove users from this group.');
        }

        // 管理者自身を削除できないようにする
        if ($user->id === $group->admin_id) {
            return redirect()->route('groups.show', $group->id)->with('error', 'You cannot remove yourself from the group.');
        }

        $group->users()->detach($user->id);

        return redirect()->route('groups.show', $group->id)->with('success', 'User removed from group successfully.');
    }
}