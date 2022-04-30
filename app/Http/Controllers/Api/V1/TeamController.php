<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = $request->input('itemsPerPage', self::ITEMS_PER_PAGE);

        $builder = QueryBuilder::for(Team::class)
            ->allowedFilters(Team::getAllowedFilters())
            ->allowedSorts(Team::getAllowedSorts())
            ->defaultSort('id')
            ->paginate($limit);

        return TeamResource::collection($builder);
    }

    public function show(Team $team): TeamResource
    {
        return new TeamResource($team);
    }

    public function store(TeamRequest $request): JsonResponse
    {
        $model = Team::create($request->validated());

        return (new TeamResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function update(Team $team, TeamRequest $request)
    {
        $team->update($request->validated());

        return (new TeamResource($team))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Team $team): JsonResponse
    {
        $team->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
