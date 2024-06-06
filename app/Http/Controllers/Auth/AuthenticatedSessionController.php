<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AccessDeniedHttpException;
use Illuminate\Support\Facades\Validator; // For custom validation

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            // Validation already handled by LoginRequest
            $request->authenticate();

            $user = $request->user();

            // Delete previous tokens
            $user->tokens()->delete();

            // Create a new token
            $token = $user->createToken('auth_token');

            return response()->json([
                'user' => $user,
                "token" => $token->plainTextToken,
            ]);
        } catch (ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'message' => 'Invalid credentials. Please try again.',
                'errors' => $e->errors(),
            ], 400); // Bad request from client
        } catch (\Exception $e) {
            // Log the error for debugging
            // \Log::error('Login error: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred. Please try again later.',
            ], 500); // Internal Server Error
        }
    }

    // ... (rest of the code)
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if ($user) {
                // Revoke all tokens for the user
                $user->tokens()->delete();
            } else {
                return response()->json(['message' => 'No authenticated user found.'], 401);
            }

            return response()->json(['message' => 'Logout successful'], 200);
        } catch (\Exception $e) {
            // \Log::error('Logout error: ' . $e->getMessage());

            return response()->json(['message' => 'Logout failed. Please try again later.', 'error' => $e->getMessage()], 500);
        }
    }
}
