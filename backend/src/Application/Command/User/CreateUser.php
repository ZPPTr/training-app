<?php declare(strict_types=1);

namespace App\Application\Command\User;

use App\Domain\User\UserUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:create',
    description: 'Create a user',
)]
class CreateUser extends Command {
    public function __construct(
        private readonly UserUseCase $useCase,
    ) {
        parent::__construct();
    }

    protected function configure(): void {
        $this->addArgument('email', InputArgument::REQUIRED, 'The user\'s email');
        $this->addArgument('role', InputArgument::REQUIRED, 'The user\'s role');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');

        $this->useCase->create($email, $role);

        return Command::SUCCESS;
    }
}
