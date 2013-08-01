<?php

namespace Keelerm\Commands;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FetchSkills extends Command
{
    protected $blacklist = array('English', 'Tae Kwon Do', 'GNU tools', 'Linux');

    protected function configure()
    {
      $this->setName('mojo:skills')
        ->setDescription('Update the database with the latest skills information from Mojolive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'http://mojolive.com/api/v1/profile?username=keelerm84&appname=matthewmkeeler';
        $content = file_get_contents($url);
        $response = json_decode($content, true);

        if ( isset($response['error']) ) {
            $output->writeln('<error>' . $response['error'] . '</error>');
            return;
        }

        $app = $this->getSilexApplication();

        $app['db']->executeQuery('TRUNCATE skills');

        $stmt = $app['db']->prepare("INSERT INTO skills (skill, months, active, rating) VALUES (:skill, :months, :active, :rating)");

        foreach($response["skills"] as $skill) {
            if ( in_array($skill['name'], $this->blacklist) || ! $skill['active'] ) continue;

            $stmt->bindValue("skill", $skill['name'], \PDO::PARAM_STR);
            $stmt->bindValue("months", $skill['months'], \PDO::PARAM_INT);
            $stmt->bindValue("active", $skill['active'], \PDO::PARAM_INT);
            $stmt->bindValue("rating", $skill['rating'], \PDO::PARAM_STR);

            $stmt->execute();
        }
    }
}
