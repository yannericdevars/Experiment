<?php
namespace DW\EntityManagerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Description of ParentCommand
 * Parent Command 
 *
 * @author Ahmed Bahet <abahet@hubee.tv>
 */
abstract class ParentCommand extends ContainerAwareCommand
{
   /**
    * Initialize whatever variables you may need to store beforehand, also load
    * Doctrine from the Container
    * 
    * @param \Symfony\Component\Console\Input\InputInterface   $input  input
    * @param \Symfony\Component\Console\Output\OutputInterface $output output
    */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output); //initialize parent class method
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager(); // This loads Doctrine, you can load your own services as well
    }
}
