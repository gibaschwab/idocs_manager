<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;

class DocumentSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $userId = $request->input('user');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $documents = Document::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
                $endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));
                $query->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
            })
            ->get();

        $users = User::all();

        return view('search', compact('documents', 'users'));
    }
}
