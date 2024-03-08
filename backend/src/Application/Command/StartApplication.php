<?php declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:start',
    description: 'Prepare app for working',
)]
class StartApplication extends Command {
    public function __construct(

    ) {
        parent::__construct();
    }

    protected function configure(): void {
//        $this->addArgument('pathToJsonFile', InputArgument::REQUIRED, 'json file with settings');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        return Command::SUCCESS;
    }
}
