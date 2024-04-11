<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Manager\DestroyPlayerPackItemRequest;
use App\Http\Requests\Manager\StorePlayerPackItemRequest;
use App\Http\Requests\Manager\UpdatePlayerPackItemRequest;
use App\Models\PlayerPack;
use App\Models\PlayerPackItem;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PlayerPackItemsEndpointController extends Controller implements HasMiddleware
{
    public function __construct()
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Model
     */
    public function store(StorePlayerPackItemRequest $request, PlayerPack $playerPack)
    {
        $playerPack->items()->create(['title' => $request->title]);

        return $playerPack->load('items')->items;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerPackItemRequest $request, PlayerPackItem $playerPackItem)
    {
        $playerPackItem->update($request->only('title'));

        return $playerPackItem->playerPack->load('items')->items;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPlayerPackItemRequest $request, PlayerPackItem $playerPackItem)
    {
        $playerPackItem->delete();

        return $playerPackItem->playerPack->load('items')->items;
    }
}
