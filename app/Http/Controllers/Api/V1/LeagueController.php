<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MatchStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\League\LeaguePredictionsRequest;
use App\Http\Requests\League\LeagueRequest;
use App\Http\Requests\League\LeagueStatsRequest;
use App\Http\Resources\LeagueResource;
use App\Models\League;
use App\Services\LeagueService;
use App\Services\MatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class LeagueController extends Controller
{
    protected LeagueService $leagueService;
    protected MatchService $matchService;

    public function __construct()
    {
        $this->leagueService = app(LeagueService::class);
        $this->matchService = app(MatchService::class);
    }

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

    public function stats(League $league, LeagueStatsRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->leagueService->getStats($league, $request->week)->values()->toArray()
        ], Response::HTTP_OK);
    }

    public function predictions(League $league, LeaguePredictionsRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->leagueService->getPredictions($league, $request->week)->values()->toArray()
        ], Response::HTTP_OK);
    }

    public function reset(League $league): JsonResponse
    {
        $this->leagueService->reset($league);
        return response()->json([], Response::HTTP_OK);
    }

    public function simulate(League $league): JsonResponse
    {
        $matches = $league
            ->matches()
            ->whereIn('status', [MatchStatusEnum::LIVE, MatchStatusEnum::UPCOMING])
            ->get();

        foreach ($matches as $match) {
            $this->matchService->simulate($match);
        }

        return response()->json([], Response::HTTP_OK);
    }

    public function simulateWeek(League $league, Request $request): JsonResponse
    {
        $matches = $league
            ->matches()
            ->whereIn('status', [MatchStatusEnum::LIVE, MatchStatusEnum::UPCOMING])
            ->byWeek($request->week)
            ->get();

        foreach ($matches as $match) {
            $this->matchService->simulate($match);
        }

        return response()->json([], Response::HTTP_OK);
    }
}
