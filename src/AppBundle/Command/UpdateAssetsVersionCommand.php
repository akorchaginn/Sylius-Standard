<?php
/**
 * Description of UpdateAssetsVersion
 *
 * @author akorchagin
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAssetsVersionCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('assets:update-version')
            ->setDescription('Update assets version');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {           
       $updater = $this->getContainer()->get('app.updater_version');
       $output->writeln($updater->updateAssetsVersion());
    }        
}
