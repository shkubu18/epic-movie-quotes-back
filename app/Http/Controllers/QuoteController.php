<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): array
	{
		$quotes = Quote::with('movie', 'comments')->latest()->paginate(3);

		return ['quotes' => QuoteResource::collection($quotes), 'last_page' => $quotes->lastPage()];
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$this->authorize('create', [Quote::class, $request->movie_id]);

		Quote::create([...$request->validated(),
			'picture'  => request()->file('picture')->store('quotes/pictures'),
		]);

		return response()->json(['message' => 'quote created successfully'], 201);
	}

	public function get(Quote $quote): array
	{
		$this->authorize('authorizeQuoteAccess', $quote);

		return ['quote'  => QuoteResource::make($quote)];
	}

	public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$this->authorize('authorizeQuoteAccess', $quote);

		$quote->update([...$request->validated(),
			'picture'  => $request->hasFile('picture') ? request()->file('picture')->store('quotes/pictures') : $quote->picture,
		]);

		return response()->json(['message' => 'quote updated successfully']);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$this->authorize('authorizeQuoteAccess', $quote);

		$quote->delete();

		return response()->json(['message' => 'Quote deleted successfully']);
	}
}
