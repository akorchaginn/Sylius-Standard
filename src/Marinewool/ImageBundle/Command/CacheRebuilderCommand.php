<?php

/**
 * Description of CacheReloader
 *
 * @author akorchagin
 */

namespace ImageBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Liip\ImagineBundle\Command\AbstractCacheCommand;
use Symfony\Component\VarDumper\VarDumper;

class CacheRebuilderCommand extends AbstractCacheCommand{

    protected function configure()
    {
        $this
            ->setName('cache:image:rebuild')
            ->setDescription('Rebuild images cache')
            ->addOption('filter', 'f', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Filter name to remove caches of (passing none will use all registered filters)')
            ->addOption('machine-readable', 'm', InputOption::VALUE_NONE,
                'Enable machine parseable output (removing extraneous output and all text styles)')
            ->addOption('filters', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Deprecated in 1.9.0 and removed in 2.0.0 (use the --filter option instead)')
            ->addOption('debug', null, InputOption::VALUE_NONE,
                'Only displying list of file')
            ->setHelp(<<<'EOF'
The <comment>%command.name%</comment> command removes asset cache for the passed filter(s).

<comment># bin/console %command.name% --filter=thumb_sm --filter=thumb_lg</comment>
Removes caches for all images using <options=bold>thumb_sm</> and <options=bold>thumb_lg</> filters, outputting:
  <info>- *[thumb_sm] rebuild</>
  <info>- *[thumb_lg] rebuild</>

<comment># bin/console %command.name% --filter=thumb_sm</comment>
Removes <options=bold>all caches</> for <options=bold>thumb_sm</> filter, outputting:
  <info>- *[thumb_sm] rebuild</>

<comment># bin/console %command.name%</comment>
Removes <options=bold>all caches</> for all filters, outputting:
  <info>- glob-rebuild</>
  
EOF
            );
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $time_start = date("U");
        
        $utils = $this->getContainer()->get('image.utils');
        $this->initializeInstState($input, $output);        
        $filters = $this->resolveFilters($input);
        
        if (0 != count($filters)) {
            $this->doCacheRemoveAsGlobbedFilterName($filters);
        }
        
        $files = array();
        $files = $utils->fetchFiles('web/media/image');
        
        if ($input->getOption('debug')) {
            VarDumper::dump($files);
            die();            
        }
      
        $output->writeln('Start cache build');
        
        foreach ($files as $t) {
            foreach ($filters as $f) {
               $this->doCacheResolve($t, $f, true);
            }
        }
        $output->writeln('Finish cache build');
        
        $this->writeResultSummary($filters, $files);
        $time_finish = date("U");
        
        $output->writeln('Duration:' . (intval($time_finish) - intval($time_start)));
        
        return $this->getReturnCode();
    }   
  
    /**
     * @param string[] $filters
     */
    private function doCacheRemoveAsGlobbedFilterName(array $filters)
    {
        foreach ($filters as $f) {
            $this->doCacheRemove($f);
        }
        
        $this->writeResultSummary($filters, array(), true);
    }


    /**
     * @param string      $filter
     * @param string|null $target
     */
    private function doCacheRemove($filter, $target = null)
    {
        $this->writeActionStart($filter, $target);

        try {
            if (null === $target) {
                $this->getCacheManager()->remove(null, $filter);
                $this->writeActionResult('glob-removal', false);
            } elseif ($this->getCacheManager()->isStored($target, $filter)) {
                $this->getCacheManager()->remove($target, $filter);
                $this->writeActionResult('removed', false);
            } else {
                $this->writeActionResult('skipped', false);
            }
        } 
        catch (\Exception $e) {
            $this->writeActionException($e);
        }
    }
    /**
     * @param string $target
     * @param string $filter
     * @param bool   $forced
     */
    private function doCacheResolve($target, $filter, $forced)
    {
        try {
            if ($forced || !$this->getCacheManager()->isStored($target, $filter)) {
                $this->getCacheManager()->store($this->getFilterManager()->applyFilter($this->getDataManager()->find($filter, $target), $filter), $target, $filter);
                //$this->writeActionResult('resolved');
            } else {
                $this->writeActionStart($filter, $target);
                $this->writeActionResult('skipped');
                $this->writeActionDetail($this->getCacheManager()->resolve($target, $filter));
            }
            
        } catch (\Exception $e) {
            $this->writeActionException($e);
        }
    }
 
}
