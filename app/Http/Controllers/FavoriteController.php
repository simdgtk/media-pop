<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $user = $request->user();
        $articleId = $request->input('article_id');

        if (!$articleId) {
            return response()->json(['error' => 'Article ID manquant'], 400);
        }

        $favorites = $user->favorites ?? [];

        if (in_array($articleId, $favorites)) {
            $favorites = array_values(array_diff($favorites, [$articleId]));
        } else {
            $favorites[] = $articleId;
        }

        $user->favorites = $favorites;
        $user->save();

        return response()->json([
            'favorites' => $user->favorites,
            'status' => 'success'
        ]);
    }
}
