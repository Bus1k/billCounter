<?php
namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupsUsers;
use App\Models\User;
use Illuminate\Support\Str;

class GroupRepository
{
    private Group $groupModel;
    private GroupsUsers $groupUsersModel;

    public function __construct(Group $groupModel, GroupsUsers $groupUsersModel)
    {
        $this->groupModel      = $groupModel;
        $this->groupUsersModel = $groupUsersModel;
    }

    public function create(string $name, string $description)
    {
        return $this->groupModel->create([
            'name'        => $name,
            'description' => $description,
            'token'       => $this->generateToken()
        ]);
    }

    public function delete(Group $group)
    {
        $group->delete();
    }

    public function assignUsers(int $groupId, array $userIds)
    {
        $data = [];
        foreach($userIds as $id) {
            $data[] = [
                'group_id' => $groupId,
                'user_id'  => $id
            ];
        }

        $this->groupUsersModel->insert($data);
    }

    public function getGroupsByUserId(int $userId)
    {
        return User::find($userId)->groups;
    }

    private function generateToken($length = 16)
    {
        $token = Str::random($length);
        if($this->groupModel->where('token', $token)->first()) {
            return $this->generateToken();
        }

        return $token;
    }
}
