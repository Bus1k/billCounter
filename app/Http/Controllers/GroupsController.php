<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    private const RULES = [
        'name'        => 'required|string|min:3|max:50',
        'description' => 'required|string|min:3|max:50',
        'color'       => 'required'
    ];

    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        return view('groups.groups', [
            'groups' => $this->groupRepository->getGroupsByUserId(Auth::id())
        ]);
    }

    public function create()
    {
        return view('groups.create', [
            'users' => User::where('id', '!=', Auth::id())->get(['name'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(self::RULES);

        $group = $this->groupRepository->create(
            $request->name,
            $request->description,
            $request->color
        );

        $userIds[] = Auth::id();
        if($request->users){
            $userIds = array_merge($userIds, User::whereIn('name', $request->users)->pluck('id')->toArray());
        }
        $this->groupRepository->assignUsers($group->id, $userIds);

        return redirect(route('index_groups'))
            ->with('success', 'Group created successfully');
    }

    public function edit(Group $group)
    {
        $groupUsers = $this->groupRepository->getUsersByGroupId($group->id)->pluck('name')->toArray();

        return view('groups.edit', [
            'group' => $group,
            'users' => User::where('id', '!=', Auth::id())->get(['name']),
            'members' => $groupUsers
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $request->validate(self::RULES);

        ddd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
