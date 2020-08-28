<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Exceptions\FailedTo;
use App\Helpers\ApiKeyHelper;
use App\Helpers\ApiValidator;
use App\Helpers\LogHelper;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('key.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserResource|JsonResponse
     */
    public function index()
    {
        $search = request()->query('search');
        $search = Str::length($search) > 0 ? $search : '.*';

        $users = User::where('name', 'regexp', '/' . $search . '/i');

        $length = intval(request()->query('length') ?? 10);
        $order = request()->query('column') ?? '_id';
        if ($order == 'id')
            $order = '_id';
        $direction = request()->query('dir') ?? 'ASC';

        $users->orderBy($order, $direction);

        return new UserResource($users->paginate($length));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return UserResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:user'],
            'password' => ['required', 'min:8'] //TODO: Validate ApiKey
        ]);

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make(request()->input('password'));

        $user->remember_token = $request->input('remember_token') ?? Str::random(10);
        $user->ApiKey = $request->input('api-key') ?? ApiKeyHelper::generate();
        $user->role = $request->input('role') ?? 2;


        if ($user->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $user, LogHelper::User, "Store");
            return new UserResource($user);
        }
        return FailedTo::Store();
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return UserResource|JsonResponse|Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user->exists) return ResponseWrapper::wrap('User not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $user->name = $request->filled('name') ? $request->input('name') : $user->name;
        $user->email = $request->filled('email') ? $request->input('email') : $user->email;
        $user->password = $request->filled('password') ? Hash::make(request()->input('password')) : $user->password;
        $user->remember_token = $request->filled('remember_token') ? $request->input('remember_token') : $user->remember_token;
        $user->ApiKey = $request->filled('api-key') ? $request->input('api-key') : $user->ApiKey;
        $user->role = $request->filled('role') ? $request->input('role') : $user->role;


        if ($user->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $user, LogHelper::User, "Update");
            return new UserResource($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return UserResource|JsonResponse|Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user || !$user->exists) return ResponseWrapper::wrap('User not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if ($user->delete()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom(request()->header('api-key')), $user, LogHelper::User, "Destroy");
            return new UserResource($user);
        }
        return ResponseWrapper::wrap('User not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }
}
