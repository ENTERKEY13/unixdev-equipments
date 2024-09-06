<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\EquipmentTypes;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEquipmentController extends Controller
{

    public function equipment(): View
    {
        return view('admin.equipment.form');
    }


    public function submit_equipment(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'th_name' => 'required|string',
            'en_name' => 'required|string',
        ]);

        try {
            EquipmentTypes::create($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Data saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function equipment_list(): View
    {
        return view('admin.equipment.list');
    }

    public function equipment_data(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $query = EquipmentTypes::query()
                ->select(['id', 'th_name', 'en_name']);

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'th_name' => $item->th_name,
                    'en_name' => $item->en_name,
                ];
            });

            $totalRecords = EquipmentTypes::count();
            $filteredRecords = $data->count();

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            \Log::error('Exception Message: ' . $e->getMessage());

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function user_equipment_list(): View
    {
        $items = Equipments::query()->select('amount', 'price')->get();
        $calculate_all_amount = $items->reduce(function ($carry, $item) {
            return $carry + ($item->amount * $item->price);
        }, 0);
        return view('admin.equipment.user-list', compact('calculate_all_amount'));
    }


    public function user_equipment_data(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $query = Equipments::query()
                ->select([
                    'equipments.id',
                    'equipments.created_at',
                    'equipments.name',
                    'equipments.amount',
                    'equipments.price',
                    'equipment_types.th_name as equipment_th_name',
                    'equipment_types.en_name as equipment_en_name',
                    'users.name as user_name',
                ])
                ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipments.equipment_type_id')
                ->leftJoin('users', 'users.id', '=', 'equipments.user_id');

            $totalRecords = Equipments::query()->count();
            $filteredRecords = $query->count();

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'created_at' => $item->created_at->format('Y-m-d'),
                    'name' => $item->name,
                    'amount' => $item->amount,
                    'price' => number_format($item->price, 2),
                    'equipment_name' => $item->equipment_th_name . ' : ' . $item->equipment_en_name,
                    'user_name' => $item->user_name,
                    'allAmount' => number_format($item->amount * $item->price, 2),
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            \Log::error('Exception Message: ' . $e->getMessage());

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}
