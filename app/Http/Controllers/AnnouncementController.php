<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnnouncement;
use App\Http\Requests\UpdateAnnouncement;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('id')->paginate(9);
        $categories = DB::select('select * from `announcements_category`');
        return view('announcement.index', compact(['announcements', 'categories']));
    }

    public function create()
    {
        $categories = DB::select('select * from `announcements_category`');
        return view('announcement.create', compact('categories'));
    }

    public function store(CreateAnnouncement $request)
    {
        $validated = $request->validated();

        if (isset($validated['unlimited_amount']))
            unset($validated['amount']);
        if (isset($validated['unlimited_cost']))
            unset($validated['cost']);

        Announcement::create($validated);

        return redirect()->back()->with('success', 'Gratulacje! Właśnie dodałeś nowe ogłoszenie.');
    }

    public function show(Announcement $announcement)
    {
        return view('announcement.show', compact('announcement'));
    }

    public function put(Announcement $announcement, UpdateAnnouncement $request)
    {
        abort_if(!auth()->user()->is_admin && $announcement->user_id !== auth()->id(), 403);

        $validated = $request->validated();

        if (isset($validated['unlimited_amount']))
            $validated['amount'] = NULL;
        if (isset($validated['unlimited_cost']))
            $validated['cost'] = NULL;

        $announcement->update($validated);
        return redirect()->back()->with('success', 'Pomyślnie edytowałeś ogłoszenie.');
    }

    public function destroy(Announcement $announcement)
    {
        abort_if(!auth()->user()->is_admin && $announcement->user_id !== auth()->id(), 403);

        $announcement->delete();
        return redirect()->route('announcement.index')->with('success', 'Pomyślnie zakończyłeś ogłoszenie.');
    }
}
