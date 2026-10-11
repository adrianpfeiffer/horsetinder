<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Horse;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LikeController extends Controller
{
    /**
     * Let one of the logged-in user's horses like another owner's horse.
     */
    public function store(Request $request, Horse $horse): RedirectResponse
    {
        if (! $horse->is_active) {
            abort(404);
        }

        if ($horse->user_id === $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'horse_id' => [
                'required',
                Rule::exists('horses', 'id')->where('user_id', $request->user()->id),
                Rule::unique('likes')->where('target_horse_id', $horse->id),
            ],
        ], [
            'horse_id.required' => 'Choose which of your horses likes '.$horse->name.'.',
            'horse_id.exists' => 'Choose one of your own horses.',
            'horse_id.unique' => 'That horse already likes '.$horse->name.'.',
        ]);

        Like::create([
            'horse_id' => $validated['horse_id'],
            'target_horse_id' => $horse->id,
        ]);

        $isMatch = $horse->givenLikes()->where('target_horse_id', $validated['horse_id'])->exists();

        if ($isMatch) {
            return redirect()->route('horses.show', $horse)
                ->with('status', "It's a match with {$horse->name}! 🎉")
                ->with('matched_horse_id', (int) $validated['horse_id']);
        }

        return redirect()->route('horses.show', $horse)
            ->with('status', "You liked {$horse->name}.");
    }

    /**
     * Undo a like that one of the logged-in user's horses gave.
     */
    public function destroy(Request $request, Like $like): RedirectResponse
    {
        if ($like->horse->user_id !== $request->user()->id) {
            abort(403);
        }

        $like->delete();

        return redirect()->route('horses.show', $like->target_horse_id)
            ->with('status', "{$like->horse->name} no longer likes {$like->targetHorse->name}.");
    }
}
