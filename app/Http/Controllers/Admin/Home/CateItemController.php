<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\CateItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate_items = CateItem::all();
        return view('admin.settings.cate_item.index', compact('cate_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function show(CateItem $cateItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CateItem $cateItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CateItem $cateItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CateItem $cateItem)
    {
        //
    }
}
