<?php

namespace App\Http\Controllers\Api\Common\V1\Item;

use App\Actions\Item\ListItemsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Common\V1\Item\FetchItemsResource;

class FetchItemsController extends Controller
{
    public function __construct(
        private ListItemsAction $listItemsAction
    ) {}

    public function __invoke()
    {
        $items = $this->listItemsAction->execute([]);

        $responsePayload = FetchItemsResource::collection($items);

        return generateSuccessApiMessage('Fetched items successfully', 200, $responsePayload);
    }
}