<?php

namespace App\Http\Controllers;

use App\Eloquent\DataRequest\GeneDataRequest;
use App\Eloquent\DataRequest\GeneSearchRequestAssembler;
use App\Eloquent\Repository\GeneRepository;
use App\Eloquent\Transformer\GeneTransformer;
use App\Http\Request\GeneSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;

class GeneSuggestController extends Controller
{
    /**
     * @var GeneRepository
     */
    protected $repository;

    public function __construct(GeneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GeneSearchRequest $request
     *
     * @return JsonResponse
     */
    public function suggest(GeneSearchRequest $request)
    {
        /** @var GeneDataRequest $suggested */
        $suggested = $this->repository->fetchAll([]);

        $inputData = $request->validated();

        GeneSearchRequestAssembler::assembleDataRequest($suggested, $inputData);
        /** @var LengthAwarePaginator $paginator */
        $paginator = $suggested->paginate(
            $inputData[GeneSearchRequest::V_FILTER_LIMIT] ?? GeneSearchRequest::V_DEFAULT_LIMIT
        );

        $paginator->getCollection()->transform(new GeneTransformer());

        return new JsonResponse(['data' => $paginator]);
    }

    /**
     * @return View
     */
    public function suggestVue(){
        return view('genes');
    }
}
