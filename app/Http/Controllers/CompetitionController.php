<?php

namespace App\Http\Controllers;

use App\Services\FootballDataService;
use Illuminate\View\View;

class CompetitionController extends Controller
{
    public function __construct(private FootballDataService $footballDataService)
    {
    }

    public function index(): View
    {
        $data = $this->footballDataService->getCompetitions();

        $competitions = $data['competitions'] ?? [];

        return view('competitions.index', compact('competitions'));
    }
}
