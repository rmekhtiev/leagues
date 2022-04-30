<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatchRequest;
use App\Http\Resources\MatchResource;
use App\Models\Match;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class MatchController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = $request->input('itemsPerPage', self::ITEMS_PER_PAGE);

        $builder = QueryBuilder::for(Match::class)
            ->allowedFilters(Match::getAllowedFilters())
            ->allowedSorts(Match::getAllowedSorts())
            ->defaultSort('id')
            ->paginate($limit);

        return MatchResource::collection($builder);
    }

    public function show(Match $match): MatchResource
    {
        return new MatchResource($match);
    }

    public function store(MatchRequest $request): JsonResponse
    {
        $model = Match::create($request->validated());

        return (new MatchResource($model))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function update(Match $match, MatchRequest $request)
    {
        $match->update($request->validated());

        return (new MatchResource($match))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Match $match): JsonResponse
    {
        $match->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
