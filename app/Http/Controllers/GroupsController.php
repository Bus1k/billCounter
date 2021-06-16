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
        ddd($this->groupRepository->getGroupsByUserId(Auth::id()));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
