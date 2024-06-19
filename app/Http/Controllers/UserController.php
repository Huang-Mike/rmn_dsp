<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;
    protected $authCon;

    public function __construct(
        AuthController $authCon,
        UserRepositoryInterface $userRepository,
    )
    {
        $this->authCon = $authCon;
        $this->userRepository = $userRepository;
    }

    /**
     * Create user.
     * Request email, password and role.
     *
     * @param CreateUserRequest $request
     * @return void
     */
    public function create(CreateUserRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->all());
            $tokens = $this->authCon->createTokens($user);
            return response()->json($tokens, 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
    }
}
