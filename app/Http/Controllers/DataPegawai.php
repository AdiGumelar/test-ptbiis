<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataPegawai extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function showData(){
        $data = Employees::with('positions')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Diambil',
            'data' => $data
        ]);
    }

    public function detail($id){
        $data = Employees::with('positions')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Diambil',
            'data' => $data
        ]);    
    }

    public function store(Request $request) {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code',
            'positions_id' => 'required|exists:positions,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required',
            'gender' => 'required|in:laki-laki,perempuan',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $data = $request->only([
            'employee_code',
            'positions_id',
            'name',
            'email',
            'phone',
            'gender',
            'birth_place',
            'birth_date',
            'hire_date',
            'salary',
            'status'
        ]);

        if($request->hasFile('photo')) {
            $file = $request->file('photo');

            $extension = $file->getClientOriginalExtension();

            $employeeCode = $request->employee_code;

            $fileName = $employeeCode.'.'.$extension;
            $path = $file->storeAs('employees',$fileName,'public');
            $data['photo'] = $path;
        };

        Employees::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil ditambahkan!'
        ], 201);
    }

    public function destroy($id){
        $data = Employees::findOrFail($id);

        if($data->photo){
            Storage::disk('public')->delete($data->photo);
        };

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }

    public function edit(Request $request, $id){
        $pegawai = Employees::findOrFail($id);

        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code,' . $id,
            'positions_id' => 'required|exists:positions,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required',
            'gender' => 'required|in:laki-laki,perempuan',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);
        
        $data = $request->only([
            'employee_code',
            'positions_id',
            'name',
            'email',
            'phone',
            'gender',
            'birth_place',
            'birth_date',
            'hire_date',
            'salary',
            'status'
        ]);

        $oldEmployeeCode = $pegawai->employee_code;
        $newEmployeeCode = $request->employee_code;

        if($request->hasFile('photo')){
            if ($pegawai->photo && Storage::disk('public')->exists($pegawai->photo)) {
                Storage::disk('public')->delete($pegawai->photo);
            }
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();

            $employeeCode = $request->employee_code;

            $fileName = $employeeCode.'.'.$extension;
            $path = $file->storeAs('employees',$fileName,'public');
            $data['photo'] = $path;
        }else {
            if ($oldEmployeeCode !== $newEmployeeCode && $pegawai->photo) {

                $oldPath = $pegawai->photo;
                $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
                $newFileName = $newEmployeeCode . '.' . $extension;
                $newPath = 'employees/' . $newFileName;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->move($oldPath, $newPath);
                    $data['photo'] = $newPath;
                }
            }
        }
        
        $pegawai->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data employee berhasil diupdate!'
        ], 201);
    }
}
