<?php

namespace App\Console\Commands;

use App\Models\Competition;
use App\Models\FootballMatch;
use App\Models\Standing;
use App\Models\Team;
use App\Services\FootballDataService;
use Illuminate\Console\Command;

class SyncFootballData extends Command
{
    protected $signature = 'football:sync';
    protected $description = 'Sync competitions, teams, matches and standings from Football-Data API';

    public function handle(FootballDataService $footballDataService): int
    {
        $competitionsData = $footballDataService->getCompetitions();
        $competitions = $competitionsData['competitions'] ?? [];

        foreach ($competitions as $competitionData) {
            $competition = Competition::updateOrCreate(
                ['api_id' => $competitionData['id']],
                [
                    'name' => $competitionData['name'] ?? null,
                    'code' => $competitionData['code'] ?? null,
                    'type' => $competitionData['type'] ?? null,
                    'emblem' => $competitionData['emblem'] ?? null,
                    'area_name' => $competitionData['area']['name'] ?? null,
                ]
            );

            if (empty($competition->code)) {
                continue;
            }

            $this->info("Sync competition: {$competition->name}");

            $this->syncTeams($footballDataService, $competition);
            $this->syncMatches($footballDataService, $competition);
            $this->syncStandings($footballDataService, $competition);
        }

        $this->info('Sync finished.');

        return self::SUCCESS;
    }

    private function syncTeams(FootballDataService $footballDataService, Competition $competition): void
    {
        $teamsData = $footballDataService->getTeams($competition->code);
        $teams = $teamsData['teams'] ?? [];

        foreach ($teams as $teamData) {
            Team::updateOrCreate(
                ['api_id' => $teamData['id']],
                [
                    'competition_id' => $competition->id,
                    'name' => $teamData['name'] ?? null,
                    'short_name' => $teamData['shortName'] ?? null,
                    'tla' => $teamData['tla'] ?? null,
                    'crest' => $teamData['crest'] ?? null,
                ]
            );
        }
    }

    private function syncMatches(FootballDataService $footballDataService, Competition $competition): void
    {
        $matchesData = $footballDataService->getMatches($competition->code);
        $matches = $matchesData['matches'] ?? [];

        foreach ($matches as $matchData) {
            FootballMatch::updateOrCreate(
                ['api_id' => $matchData['id']],
                [
                    'competition_id' => $competition->id,
                    'home_team_api_id' => $matchData['homeTeam']['id'] ?? null,
                    'away_team_api_id' => $matchData['awayTeam']['id'] ?? null,
                    'home_team_name' => $matchData['homeTeam']['name'] ?? null,
                    'away_team_name' => $matchData['awayTeam']['name'] ?? null,
                    'utc_date' => $matchData['utcDate'] ?? null,
                    'status' => $matchData['status'] ?? null,
                    'matchday' => $matchData['matchday'] ?? null,
                    'home_score' => $matchData['score']['fullTime']['home'] ?? null,
                    'away_score' => $matchData['score']['fullTime']['away'] ?? null,
                ]
            );
        }
    }

    private function syncStandings(FootballDataService $footballDataService, Competition $competition): void
    {
        $standingsData = $footballDataService->getStandings($competition->code);
        $standings = $standingsData['standings'][0]['table'] ?? [];

        Standing::where('competition_id', $competition->id)->delete();

        foreach ($standings as $row) {
            Standing::create([
                'competition_id' => $competition->id,
                'team_api_id' => $row['team']['id'] ?? null,
                'team_name' => $row['team']['name'] ?? '',
                'position' => $row['position'] ?? null,
                'played_games' => $row['playedGames'] ?? 0,
                'won' => $row['won'] ?? 0,
                'draw' => $row['draw'] ?? 0,
                'lost' => $row['lost'] ?? 0,
                'points' => $row['points'] ?? 0,
                'goals_for' => $row['goalsFor'] ?? 0,
                'goals_against' => $row['goalsAgainst'] ?? 0,
                'goal_difference' => $row['goalDifference'] ?? 0,
            ]);
        }
    }
}
