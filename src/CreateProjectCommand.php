<?php

namespace Medpets\Assignments;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class CreateProjectCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('start')
            ->setDescription('Create a new project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question('Wat is je naam? ', '');

        $name = $helper->ask($input, $output, $question);

        if (empty($name)) {
            $name = 'Pietje';
            $output->writeln('<fg=green>Ok, dan noemen we je gewoon <fg=green;options=bold>Pietje</></>');
            $output->writeln('<comment>------------</comment>');
        }

        $output->writeln('<fg=green>Hallo <fg=green;options=bold>'.$name.'</> 👋</>');
        $output->writeln("<fg=green>We gaan je project in elkaar zetten. Sit back and relax 🚀</>");
        $output->writeln('<comment>------------</comment>');

        $process = new Process(['composer', 'create-project', 'laravel/laravel', 'assignment-app']);
        $process->run();
        $output->writeln($process->getOutput());

        $output->writeln('<fg=green>We hebben een project voor je aangemaakt in de <fg=green;options=bold>assignment-app</> directory. 🎉</>');
        $output->writeln('<fg=green>Nu nog wat dingetjes toevoegen. 📦</>');
        $output->writeln('<comment>------------</comment>');

        $commands = [
            ['composer', 'require', 'livewire/livewire'],
            ['php', 'artisan', 'livewire:publish', '--config'],
            ['php', 'artisan', 'livewire:publish', '--assets'],
            ['composer', 'install'],
            ['npm', 'install', 'alpinejs'],
            ['npm', 'install'],
            ['npm', 'run', 'build']
        ];
        foreach ($commands as $command) {
            $process = new Process($command, __DIR__ . '/../assignment-app');
            $process->run();
            $output->writeln($process->getOutput());
        }

        $output->writeln('<fg=green>Alles is klaar! 🙌</>');

        return Command::SUCCESS;
    }
}
