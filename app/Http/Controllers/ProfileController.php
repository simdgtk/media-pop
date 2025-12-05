<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profil mis à jour avec succès']);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Compte supprimé']);
        }

        return Redirect::to('/');
    }

    /**
     * Update the user's favorites.
     */
    public function toggleFavorite(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $articleId = (int) $request->input('article_id');

        if (!$articleId) {
            return response()->json(['error' => 'Article ID manquant'], 400);
        }
        
        $favorites = $user->favorites ?? [];
        
        $isFavorited = in_array($articleId, $favorites);

        if ($isFavorited) {
            $favorites = array_values(array_diff($favorites, [$articleId]));
        } else {
            $favorites[] = $articleId;
        }

        $user->favorites = $favorites;
        $user->save();

        return response()->json([
            'favorites' => $user->favorites,
            'is_favorited' => !$isFavorited, // L'état après la modification
            'status' => 'success'
        ]);
    }

    public function getFavorites(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        return response()->json([
            'favorites' => $user->favorites ?? [],
        ]);
    }
}
