<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    
    
    public function uploadImage(ClientRequest $request)
    {
      
    
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
    
            // Save the image to the public disk under the 'images' directory
            $image->storeAs('public/images', $imageName);
            $path = '/storage/images/'.$imageName;
            // Get the authenticated user
            $user = User::find(Auth::user()->id);
    
            // Update the profile_picture field in the database
            $user->update(['profile_picture' => $path ]);
    
            return response()->json(['url' => $path ]);
        }
    
        return response()->json(['error' => 'Image not found.'], 400);
    }
}
