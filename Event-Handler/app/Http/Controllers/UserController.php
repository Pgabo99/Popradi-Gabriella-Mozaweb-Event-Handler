<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Redirects the user for the Profile edit page
     * @param \App\Models\User $user the edtiable in user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse 
     */
    public function show(User $user)
    {
        if (Auth::id() === $user->id) {
            $editing = false;
            return view("user.show", compact("user", "editing"));
        }
        return redirect(route("home"))->with("message", 'Cseles vagy!');
    }

    /**
     * Switching for editing mode at the Pofile edit page
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View Pofile edit page
     */
    public function edit(User $user)
    {
        $editing = true;
        return view("user.show", compact("user", "editing"));
    }

    /**
     * Updates the User based on the Profile page editing form 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "email" => "required|email",
            "name" => "required|string",
        ]);
        if ($data["email"] === $user->email && auth()->user()->name === $data["name"]) {
            return redirect(route("user.edit", $user))->with("warning", "Nem is változtattál semmit");
        }
        if ($data["email"] !== $user->email) {
            $request->validate([
                "email" => "unique:App\Models\User",
            ]);
        }
        $thisUser = User::findOrFail($user->id);
        if ($thisUser->update($data)) {
            return redirect(route("user.show", $user))->with("success", "Mentve!");
        }

        return redirect(route("user.edit", $user))->with("error", "Sikertelen, próbáld újra");
    }

    /**
     * Deletes the user 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $thisUser = User::findOrFail($user->id);
        if ($thisUser->delete($user->email)) {
            Auth::logout();
            return redirect(route("home"))->with("success", "Sikeres törlés!");
        }
        return redirect(route("user.edit", $user))->with("error", "Sikertelen, próbáld újra");
    }
}
