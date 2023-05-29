<?php

namespace App\Http\Controllers\laravel_example;

use App\Http\Controllers\Controller;
use App\Models\Infos;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagement extends Controller
{
    /**
     * Redirect to user-management view.
     *
     */
    public function UserManagement()
    {
        $users = User::all();
        $userCount = $users->count();
        $verified = User::whereNotNull('email_verified_at')
            ->get()
            ->count();
        $notVerified = User::whereNull('email_verified_at')
            ->get()
            ->count();
        $usersUnique = $users->unique(['email']);
        $userDuplicates = $users->diff($usersUnique)->count();

        return view('content.laravel-example.user-management', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'email_verified_at',
        ];

        $search = [];

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;
            foreach ($users as $user) {

                $info = Infos::where('user_id', $user->id)->first();
                $nestedData['id'] = $user->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['lansudung'] = $info->lansudung;

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userID = $request->id;

        if ($userID) {
            // update the value
            $users = User::updateOrCreate(['id' => $userID], ['name' => $request->name, 'email' => $request->email, 'lansudung' => $request->lansudung, 'password' => bcrypt($request->password)]);
            // user updated
            return response()->json('Đã cập nhật');
        } else {
            // create new one if email is unique
            $userEmail = User::where('email', $request->email)->first();

            if (empty($userEmail)) {
                $users = User::updateOrCreate(
                    ['id' => $userID],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'role' => 1,
                        'status' => 1,
                        'password' => bcrypt($request->password),
                    ]
                );
                if ($users->wasRecentlyCreated) {
                    $info = new Infos();
                    $info->user_id = $users->id;
                    $info->lansudung = $request->lansudung;
                    $info->save();
                }

                // user created
                return response()->json('Tạo thành công');
            } else {
                // user already exist
                return response()->json(['message' => 'đã tồn tại'], 422);
            }
        }
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
        $where = ['id' => $id];

        $info = Infos::where('user_id', $id)->first();

        $users = User::where($where)->first();

        $users->lansudung = $info->lansudung;

        return response()->json($users);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::where('id', $id)->delete();
    }
}
