<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\GenerateTokenService;
use sixlive\DotenvEditor\DotenvEditor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'key-generate',
    description: 'Generate APP_SECRET',
)]
class KeyGenerateCommand extends Command
{
    public function __construct(
        private string $projectDirEnv,
        private GenerateTokenService $generateTokenService
    ) {
        parent::__construct($projectDirEnv);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $secret = $this->generateTokenService->generateToken();

        $editor = new DotenvEditor();
        $editor->load($this->projectDirEnv);
        $editor->set('APP_SECRET', $secret);
        $editor->save();

        $io->success('New APP_SECRET was generated: ' . $secret);
        return Command::SUCCESS;
    }
}
