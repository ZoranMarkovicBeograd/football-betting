<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FootballDataService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.football_data.base_url');
        $this->token = config('services.football_data.token');
    }

    private function request(string $endpoint, array $query = []): array
    {
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->token,
        ])->get($this->baseUrl . $endpoint, $query);

        $response->throw();

        return $response->json();
    }

    public function getCompetitions(): array
    {
        return $this->request('/competitions');
    }

    public function getCompetition(string $code): array
    {
        return $this->request("/competitions/{$code}");
    }

    public function getStandings(string $code): array
    {
        return $this->request("/competitions/{$code}/standings");
    }

    public function getMatches(string $code): array
    {
        return $this->request("/competitions/{$code}/matches");
    }

    public function getTeams(string $code): array
    {
        return $this->request("/competitions/{$code}/teams");
    }
}
