<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('uzytkownik.show', auth()->user());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $announcements = Announcement::where('user_id', $user->id)->withTrashed()->orderByDesc('id')->paginate(9);
        $announcements_active = Announcement::where('user_id', $user->id)->count();

        return view('user.show', compact(['user', 'announcements', 'announcements_active']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate(['contact' => 'string|nullable']);
        $user = User::Find(auth()->id());
        $user->update($validated);

        return redirect()->back()->with('success', 'Pomyślnie edytowałeś pole kontaktu.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usunąłeś użytkownika.');
    }

    public function hideAnnouncements(User $user)
    {
        $user->announcements()->delete();
        return redirect()->back()->with('success', 'Ukryłeś wszystkie ogłoszenia użytkownka.');
    }

    public function markAsScammer(User $user)
    {
        $user->scammer = !$user->scammer;
        $user->update();

        return redirect()->back()->with('success', 'Zmieniłeś użytkownikowi status oszusta.');
    }

    public function addReputation(User $user)
    {
        if (auth()->id() === $user->id) return redirect()->back()->with('error', 'Nie możesz dodać sobie reputacji!');
        $count = DB::select('select `id` from `reputation_logs` where user_id = ? AND target_id = ?', [auth()->id(), $user->id]);
        if (count($count)) return redirect()->back()->with('error', 'Ten użytkownik dostał już reputację.');

        DB::insert('insert into `reputation_logs` (user_id, target_id, created_at, updated_at) values (?, ?, now(), now())', [auth()->id(), $user->id]);
        $user->reputation++;
        $user->update();

        return redirect()->back()->with('success', 'Dodałeś użytkownikowi reputację.');
    }

    public function setAsVip(User $user)
    {
        $user->is_vip = !$user->is_vip;
        $user->update();

        return redirect()->back()->with('success', 'Zmieniłeś użytkownikowi status vip\'a.');
    }

}
