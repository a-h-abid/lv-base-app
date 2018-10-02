<?php

namespace App\Http\Controllers\Api\V1;

use App\Eloquents\User;
use App\Exceptions\InactiveModelException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRegisterFormRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Spatie\Permission\Models\Role;

class UserController extends AccessTokenController
{
    /**
     * Register User
     *
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function register(UserRegisterFormRequest $request)
    {
        $data = $request->validated();
        $data['active'] = 1;

        $user = User::create($data);

        $role = Role::findByName($data['role'], 'api');
        $user->syncRoles($role);

        return [
            'success' => true,
            'code' => 200,
            'message' => 'Registration has been successful.',
            'data' => [
                'user' => $user,
            ],
        ];
    }

    /**
     * Login User
     *
     * @param  ServerRequestInterface $request
     * @return Illuminate\Http\Response
     */
    public function login(ServerRequestInterface $request)
    {
        try {
            $requestBody = $request->getParsedBody();

            $username = $requestBody['username'] ?? null;
            $user = User::with('roles')->where('email', '=', $username)->first();
            if (empty($user)) {
                throw new ModelNotFoundException("User not found", 500);
            }

            if ($user->active == 0) {
                throw new InactiveModelException("User is not active", 500);
            }

            $request = $request->withParsedBody($requestBody + [
                'grant_type' => 'password',
            ]);

            $tokenResponse = parent::issueToken($request);

            // convert response json to array
            $content = $tokenResponse->getContent();
            $data = json_decode($content, true);
            if (isset($data['error'])) {
                return Response::json([
                    'success' => false,
                    'code' => 401,
                    'message' => $data['message'],
                ], 401);
            }

            return Response::json([
                'success' => true,
                'code' => 200,
                'message' => 'Login has been successful.',
                'data' => [
                    'user' => $user,
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'expires_in' => $data['expires_in'],
                ]
            ]);
        }
        catch (ModelNotFoundException $e) {
            return response(["message" => "User not found"], 401);
        }
        catch (InactiveModelException $e) {
            return response(["message" => "The user is not active"], 401);
        }
        catch (OAuthServerException $e) {
            return response(["message" => "The user credentials were incorrect."], 401);
        }
        catch (\Exception $e) {
            return response(["message" => "Internal server error"], 500);
        }
    }

    /**
     * Get Logged User Info
     *
     * @param  Request $request
     * @return App\Eloquents\User
     */
    public function info(Request $request)
    {
        return [
            'success' => true,
            'code' => 200,
            'message' => 'Ok',
            'data' => [
                'user' => $request->user(),
            ],
        ];
    }

    /**
     * Logout by destroying token
     *
     * @param  Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $tokenId = $request->user()->token()->id;

        $token = $this->tokens->findForUser(
            $tokenId, $request->user()->getKey()
        );

        if (is_null($token)) {
            return new Response('', 404);
        }

        $token->revoke();

        return [
            'success' => true,
            'code' => 200,
            'message' => 'Logout has been successful.',
        ];
    }
}
