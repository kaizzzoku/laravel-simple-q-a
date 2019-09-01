<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Http\Requests\CommentStoreForQuestionRequest;
use App\Http\Requests\CommentStoreForAnswerRequest;
use App\Http\Requests\CommentUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Store comment for answer
     *
     * @param $request
     * @return void
     */
    public function storeForAnswer(CommentStoreForAnswerRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();
        $data['commentable_type'] = Answer::class;

        $comment = (new Comment())->create($data);

        if ($comment) {
            return redirect()
                ->route('questions.show', $comment->question->id)
                ->with(['success' => 'Comment successfully created']);
        } else {
            return back()
                ->withErrors(['msg' =>
                    'Error while creating comment. Please try again'])
                ->withInput();
        }
    }

    /**
     * Store comment for question
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForQuestion(CommentStoreForQuestionRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();
        $data['commentable_type'] = Question::class;

        $comment = (new Comment())->create($data);

        if ($comment) {
            return redirect()
                ->route('questions.show', $comment->question->id)
                ->with(['success' => 'Comment successfully created']);
        } else {
            return back()
                ->withErrors(['msg' =>
                    'Error while creating comment. Please try again'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('public.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $data = $request->validated();

        $updated = $comment->update($data);

        if ($updated) {
            return redirect()
                ->route('questions.show', $comment->question->id)
                ->with(['success' => "Comment with ID '$comment->id' updated"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Update error. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $destroyed = $comment->delete();

        if ($destroyed) {
            return redirect()
                ->route('questions.show', $comment->question->id)
                ->with(['success' => "Comment with ID '$comment->id' deleted"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Delete error. Please try again.']);
        }
    }
}
