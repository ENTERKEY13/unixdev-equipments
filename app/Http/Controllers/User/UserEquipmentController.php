<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\EquipmentTypes;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserEquipmentController extends Controller
{
    public function equipment_data(Request $request): \Illuminate\Http\JsonResponse
    {
        $userID = auth()->id();

        try {
            $query = Equipments::query()
                ->where('user_id', $userID)
                ->select([
                    'equipments.id',
                    'equipments.created_at',
                    'equipments.name',
                    'equipments.amount',
                    'equipment_types.th_name as equipment_th_name',
                    'equipment_types.en_name as equipment_en_name'
                ])
                ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipments.equipment_type_id');

            $totalRecords = Equipments::where('user_id', $userID)->count();
            $filteredRecords = $query->count();

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'created_at' => $item->created_at->format('Y-m-d'),
                    'name' => $item->name,
                    'amount' => $item->amount,
                    'equipment_name' => $item->equipment_th_name . ' : ' . $item->equipment_en_name,
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
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function equipment(): View
    {
        return view('user.equipment.form');
    }

    public function search_equipments(Request $request): JsonResponse
    {
        $searchString = strtolower($request->get('s', ''));

        return response()->json([
            'equipments' => EquipmentTypes::query()
                ->where(function ($q) use ($searchString) {
                    $q->where(DB::raw('LOWER(th_name)'), 'like', "%{$searchString}%")
                        ->orWhere('en_name', 'like', "%{$searchString}%")
                        ->orWhere('id', 'like', "%{$searchString}%");
                })
                ->limit(20)
                ->orderBy('id', 'asc')
                ->get(['id', 'th_name', 'en_name'])
        ]);
    }

    public function submit_equipment(Request $request): JsonResponse
    {
        $equipment = $request->input('equipment_type_id');
        $userID = auth()->id();
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'equipment_type_id' => 'required',
            'amount' => $equipment === '3' ? 'required|numeric' : 'nullable',
        ]);

        Equipments::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'amount' => $request->input('amount'),
            'equipment_type_id' => $request->input('equipment_type_id'),
            'user_id' => $userID,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function equipment_list(): View
    {
        $userID = auth()->id();
        $items = Equipments::query()
            ->where('user_id', $userID)
            ->select([
                'equipments.id',
                'equipments.created_at',
                'equipments.name',
                'equipments.amount',
                'equipments.price',
                'equipment_types.th_name as equipment_th_name',
                'equipment_types.en_name as equipment_en_name'
            ])
            ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipments.equipment_type_id')
            ->get();

        $calculate_all_amount = $items->reduce(function ($carry, $item) {
            return $carry + ($item->amount * $item->price);
        }, 0);

//        dd($items, $calculate_all_amount);
        return view('user.equipment.list', compact('items', 'calculate_all_amount'));
    }

    public function equipment_list_edit(Request $request, $id): \Illuminate\Contracts\View\Factory|View|Application
    {
        $equipment = Equipments::find($id);
        return view('user.equipment.form', compact('equipment'));
    }

    public function equipment_list_update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'equipment_type_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'amount' => 'nullable|numeric'
        ]);

        $equipment = Equipments::findOrFail($id);
        $equipment->update($validated);

        return response()->json(['status' => 'success']);
    }

//    public function user_equipment_list(): View
//    {
//        return view('user.equipment.user-list');
//    }
}
