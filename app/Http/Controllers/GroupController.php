<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Group;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return Inertia::render('Dashboard', [
            'joinRequests' => $joinRequests,
        ]);
    }

    public function show(Group $group)
    {
        return Inertia::render('Group/Show', [
            'group' => $group,
            'users' => $group->users,
        ]);
    }
}