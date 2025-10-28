<?php

namespace App\Repository;

use App\Model\StarshipModel;
use App\Model\StarshipStatusEnum;
use Psr\Log\LoggerInterface;

class StarshipModelRepository
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function findAll(): array
    {
        $this->logger->info('StarshipModel collection retrieved');

        return [
            new StarshipModel(
                1,
                'USS LeafyCruiser (NCC-0001)',
                'Garden',
                'Jean-Luc Pickles',
                StarshipStatusEnum::IN_PROGRESS
            ),
            new StarshipModel(
                2,
                'USS Espresso (NCC-1234-C)',
                'Latte',
                'James T. Quick!',
                StarshipStatusEnum::COMPLETED
            ),
            new StarshipModel(
                3,
                'USS Wanderlust (NCC-2024-W)',
                'Delta Tourist',
                'Kathryn Journeyway',
                StarshipStatusEnum::WAITING
            ),
        ];
    }

    public function find(int $id): ?StarshipModel
    {
        foreach ($this->findAll() as $starship) {
            if ($starship->getId() === $id) {
                return $starship;
            }
        }

        return null;
    }
}
