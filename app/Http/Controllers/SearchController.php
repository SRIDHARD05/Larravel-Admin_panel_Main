<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\SearchNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function dashboard(Request $request)
    {
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $position = $request->input('position');

        $employees = Employee::query();

        if ($firstName) {
            $employees = $employees->where('first_name', 'like', '%' . $firstName . '%');
        }
        if ($lastName) {
            $employees = $employees->where('last_name', 'like', '%' . $lastName . '%');
        }
        if ($email) {
            $employees = $employees->where('email', 'like', '%' . $email . '%');
        }
        if ($position) {
            $employees = $employees->where('position', 'like', '%' . $position . '%');
        }

        $data = $employees->paginate(100);

        return view('search', compact('data'));
    }

    public function file_download_notify(Request $request)
    {
        $message = "Employee Data's has been successfully download as Json File " . now();
        $user = User::find(Auth::user()->id);

        $user->notify(new SearchNotification($user, $message));

        Log::info('File download requested by user', [
            'user_name' => $user->name,
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'download_time' => now(),
        ]);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    // public function download_file(Request $request)
    // {
    //     $data = $request->json()->all();

    //     $selectedIds = $data['selectedIds'];
    //     $type = $data['type']; // csv, excel, pdf, text


    //     return response()->json([
    //         'selectedIds' => $selectedIds,
    //         'type' => $type
    //     ]);
    // }


    public function test()
    {
        $users = Cache::remember('cacheKey', 60, function () {
            // If not found in cache, fetch the paginated data from the database
            return DB::table('employees')->paginate(100);
        });
    }
}
