<?php
namespace DW\EntityManagerBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DW\EntityManagerBundle\Command\ParentCommand;

/**
 * TestCommand to use entity Manager 
 *
 * @author Ahmed Bahet <abahet@hubee.tv>
 */
class TestCommand extends ParentCommand
{

  protected function configure()
  {
    $this->setName('DW:Test')->setDescription('Test command');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->em;
     
    }
  }

}
