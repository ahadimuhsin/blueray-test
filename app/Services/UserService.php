<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class UserService
{

    protected $policy;

    public function __construct(UserPolicy $policy)
    {
        $this->policy = $policy;
    }
    public function index($request)
    {
        $role = $request->user()->role;

        try
        {
            $users = User::select("id", "name", "email")
            ->when($role == User::ROLE_USER, function($q) use($request){
                $q->where("id", $request->user()->id);
            })
            ->orderBy("name", "ASC")
            ->get();

            return $users;
        }
        catch (Exception $e)
        {
            Log::error('Error fetching users: '. $e->getMessage());

            throw new Exception('An error occurred while fetching users.', $e->getCode());
        }
    }

    public function show($id, $request)
    {
        try
        {
            if ($this->policy->view($request->user(), $id)) {

                $user = User::find($id);

                if(!$user)
                {
                    throw new Exception('User Not Found', 404);
                }

                return $user;
            }
            else {
                throw new Exception('Unauthorized access.', 403);
            }
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function update($id, $request)
    {
        try {
            if ($this->policy->update($request->user(), $id))
            {

                $user = User::find($id);

                if(!$user)
                {
                    throw new Exception('User Not Found', 404);
                }

                $user->name = $request->name ?? $user->name;
                $user->email = $request->email ?? $user->email;
                $user->save();
            }
            else {
                throw new Exception('Unauthorized access.', 403);
            }

            return $user;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($id, $request)
    {
        try {
            if ($this->policy->delete($request->user()))
            {

                $user = User::find($id);

                if(!$user)
                {
                    throw new Exception('User Not Found', 404);
                }

                $user->delete();
            }
            else {
                throw new Exception('Unauthorized access.', 403);
            }

            return response()->json([], 204);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
