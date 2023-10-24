<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
    
        $comment = Comment::create([
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'user_id' => auth()->user()->id, // Assign the authenticated user's ID to the appointment
        ]);

        return response()->json(['message' => 'Comment created successfully'], 201);
    }

    public function index()
    {
        $comments = Comment::all();

        return response()->json($comments);
    }

    
    public function update(CommentRequest $request, string $id)
    {
      
    
    $comment = Comment::findOrFail($id);
    // commente appointment
   
    $comment->name = $request->name ;
    $comment->email = $request->email;
    $comment->comment = $request->comment;
    $comment->save();

    // Return the updated appointment as a response
    return response()->json($comment, 201);
    }

    public function destroy(string $id)
    {
       // Retrieve the appointment by ID
       $comment = Comment::findOrFail($id);

       // Delete the appointment
       $comment->delete();

       // Return a success response
       return response()->json(['message' => 'Appointment deleted successfully']);
    }

            public function getProfilePictureByCommentId($commentId)
        {
            // Retrieve the comment by its ID
            $comment = Comment::findOrFail($commentId);

            // Get the associated user and their profile picture
            $user = $comment->user;
            $profilePicture = $user->profile_picture;

            // You can return the profile picture URL or any other data as needed
            return response()->json(['profile_picture' => $profilePicture]);
        }
    
}
