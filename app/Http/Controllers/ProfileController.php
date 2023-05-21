<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ChangeCredentialsRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\ChangePhoneRequest;
use App\Models\Result;
use App\Models\Test;
use App\Models\User;
use App\Services\HashService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile(User $user)
    {
        $tests = $user->tests()
                      ->where('is_active', 1)
                      ->orderByDesc('id')
                      ->paginate(8);

        return view('profile.show', compact('user', "tests"));
    }

    public function showResults(User $user)
    {
        $results = $user->results()->orderBy('id', 'desc')->get();
        return view('profile.results', compact('user', "results"));
    }

    public function showHidedTests(User $user)
    {
        $this->authorize('edit', $user);
        $tests = Test::where('is_active', 0)
                     ->orderByDesc('id')
                     ->paginate(16);
        return view('profile.show_hided_tests', compact('user', "tests"));
    }

    public function editProfileForm(Request $request, User $user)
    {
        $this->authorize('edit', $user);
        return view('profile.form', compact('user'));
    }

    public function changePhone(ChangePhoneRequest $request, User $user)
    {
        $this->authorize('edit', $user);
        $user->update($request->validated());

        return redirect()->route('profile.show', $user->id)->with(
            ['success' => __('profileSettings.changePhone.success.success')]
        );
    }

    public function changeCredentials(ChangeCredentialsRequest $request, User $user)
    {
        $this->authorize('edit', $user);
        $user->update($request->validated());

        return redirect()->route('profile.show', $user->id)->with(
            ['success' => __('profileSettings.changeCredentials.success.success')]
        );
    }

    public function changePassword(ChangePasswordRequest $request, User $user, HashService $hashService) {
        $this->authorize('edit', $user);
        if (!$hashService->validate($request->old_password, $user->password)) {
            return redirect()->route('profile.edit', $user->id)->withErrors(['password' => __('profileSettings.changePassword.fail.password')]);
        }

        $user->update(['password' => $hashService->hash($request->new_password)]);

        return redirect()->route('profile.show', $user->id)->with(['success' => __('profileSettings.changePassword.success.success')]);
    }
}
