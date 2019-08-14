<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TagStoreRequest;
use App\Http\Requests\Admin\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::getPaginatedIndex(10);

        return view('admin.tags.index', compact('tags'));
    }

    /**** Show funcs ****/

    public function info($slug)
    {
        $tag = Tag::getForShow($slug);

        return view('admin.tags.show.info', compact('tag'));
    }

    public function questions($slug)
    {
        $tag = Tag::getForShow($slug);

        return view('admin.tags.show.questions', compact('tag'));
    }

    /********/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $data = $request->validated();

        $tag = (new Tag())->create($data);

        if ($tag) {
            return redirect()
                ->route('admin.tags.info', $tag->slug)
                ->with(['msg' => "Tag '$tag->title' successfuly created"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Create Error. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $tag = Tag::getForEdit($slug);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();

        $updated = $tag->update($data);

        if ($updated) {
            return redirect()
                ->route('admin.tags.index')
                ->with(['success' =>
                    "Tag '$tag->title' successfuly updated"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Update error. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Restore tag with questions
     *
     * @param string $slug
     * @return void
     */
    public function restore($slug)
    {
        $tag = Tag::getTrashed($slug);

        $tag->restore();

        return view('admin.tags.show.info', compact('tag'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $tag = Tag::getForDestroy($slug);
        $restore_route = route('admin.tags.restore', $tag->slug);

        $deleted = $tag->delete();

        if ($deleted) {
            return redirect()
                ->route('admin.tags.index')
                ->with(['success' => "Tag '$tag->title' deleted",
                        'restore_route' => $restore_route]); 
        } else {
            return back()
                ->withErrors(['msg' => 'Delete Error. Pleast try again.']);
        }
    }
}
