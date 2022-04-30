<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeagueRequest;
use App\Http\Resources\LeagueResource;
use App\Models\League;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class LeagueController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = $request->input('itemsPerPage', self::ITEMS_PER_PAGE);

        $builder = QueryBuilder::for(League::class)
            ->allowedFilters(League::getAllowedFilters())
            ->allowedSorts(League::getAllowedSorts())
            ->defaultSort('id')
            ->paginate($limit);

        return LeagueResource::collection($builder);
    }

    public function show(League $league): LeagueResource
    {
        return new LeagueResource($league);
    }

    public function store(LeagueRequest $request): JsonResponse
    {
        $model = League::create($request->validated());

        return (new LeagueResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function update(League $league, LeagueRequest $request)
    {
        $league->update($request->validated());

        return (new LeagueResource($league))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(League $league): JsonResponse
    {
        $league->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
