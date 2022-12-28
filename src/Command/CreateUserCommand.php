<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create-user',
    description: 'Create user',
)]
class CreateUserCommand extends Command
{
    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param EntityManagerInterface $em
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface  $em
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the new user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the new user')
            ->addArgument('password', InputArgument::REQUIRED, 'The plain password of the new user');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $username */
        $username = $input->getArgument('username');

        /** @var string $email */
        $email = $input->getArgument('email');

        /** @var string $password */
        $password = $input->getArgument('password');

        $this->addUser($username, $email, $password);

        $io->success('User has been created: '. $username);
        return Command::SUCCESS;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return void
     */
    private function addUser(string $username, string $email, string $password): void
    {
        $user = new User();

        $user->setName($username);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();
    }
}
