<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class KehadiranController extends Controller
{
    public function presensi(Request $required)
    {
        $validator = Validator::make($required->all(),[
            'id_user' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }

        $save = kehadiran::create([
            'id_user'    =>$required->get('id_user'),
            'date'        =>$required->get('date'),
            'time'        =>date('H:i:s'),
            'status'        =>$required->get('status'),
        ]);
        if($save){
            return Response()->
            json([
                'status'=>true,
                'message' => 'Presensi berhasil dicatat',
                'data'=>$save]);
        }else {
            return Response()->json(['status'=>false, 'message' => 'Pengguna gagal ditambahkan']);
     }

    }

    public function show1($id_user) {
        $user = kehadiran::where('id_user',$id_user,)->get();
        return response()->json(['status'=>true, 'data' => $user]);
    }

    public function summary($id_user){
        $userRecords = kehadiran::where('id_user', $id_user)->get();
        $userGroupedByMonth = $userRecords->groupBy(function($date) {
            return Carbon::parse($date->date)->format('m-Y');
        });

        $summary = [];

        foreach ($userGroupedByMonth as $monthYear => $records) {
            // Count the statuses for each month
            $hadir = $records->where('status', 'Hadir')->count();
            $izin = $records->where('status', 'Izin')->count();
            $sakit = $records->where('status', 'Sakit')->count();

            $summary[] = [
                'month' => $monthYear,
                'attendance_summary' => [
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                ],
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id_user' => $id_user,
                    'attendance_summary_by_month' => $summary
                ]
            ]);
        
        }
    }

    public function analysis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $id_user = $request->input('id_user');
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $userRecords = Kehadiran::where('id_user', $id_user)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $userGroupedByMonth = $userRecords->groupBy(function ($date) {
            return Carbon::parse($date->date)->format('m-Y');
        });

        $summary = [];

        foreach ($userGroupedByMonth as $monthYear => $records) {
            $hadir = $records->where('status', 'Hadir')->count();
            $izin = $records->where('status', 'Izin')->count();
            $sakit = $records->where('status', 'Sakit')->count();

            $summary[] = [
                'month' => $monthYear,
                'attendance_summary' => [
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                ],
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id_user' => $id_user,
                'attendance_summary_by_month' => $summary
            ]
        ], 200);
    }


}