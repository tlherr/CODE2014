<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 2014-02-28
 * Time: 8:26 PM
 */

namespace Renegade\Bundle\CarImpactBundle\Command;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Renegade\Bundle\CarImpactBundle\Entity\Make;
use Renegade\Bundle\CarImpactBundle\Entity\Model;
use Renegade\Bundle\CarImpactBundle\Entity\Vehicle;
use Renegade\Bundle\CarImpactBundle\Entity\VehicleRepository;
use Renegade\Bundle\CarImpactBundle\Helpers\StringHelpers;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;

class DataImportCommand extends ContainerAwareCommand {

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var EntityRepository
     */
    protected $makeRepository;

    /**
     * @var EntityRepository
     */
    protected $modelRepository;

    /**
     * @var EntityRepository
     */
    protected $vehicleRepository;

    /**
     * @var array
     */
    protected $makes;

    /**
     * @var array
     */
    protected $models;

    protected function configure()
    {
        $this
            ->setName('cars:data:import')
            ->setDescription('Import mileage data from CSV')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File to import'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = realpath($input->getArgument('file'));
        $this->prepareObjects();
        if ($this->isFileImportable($file)) {
            $this->processFile($output, $file);
        } else {
            $output->writeln(sprintf('Unable to import from %s.', $file));
        }
    }

    /**
     * Parse file and create vehicle data
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param $filename
     */
    protected function processFile(OutputInterface $output, $filename)
    {
        $file = fopen($filename, 'r');
        $tempFile = tmpfile();
        $recordCount = 0;
        $persistedRecords = 0;

        while ($record = fgetcsv($file)) {
            $recordCount++;
            if ($this->isRecordValid($record)) {
                //
                $make = $this->getOrCreateMake($record[1]);
                $model = $this->getOrCreateModel($make, $record[2]);

                // Create the vehicle
                $newVehicle = new Vehicle();
                $newVehicle->setYear($record[0]);
                $newVehicle->setModel($model);
                $newVehicle->setEngineSize($record[4]);
                $newVehicle->setCylinders($record[5]);

                // Is this a "special" model
                $newVehicle->setTransmissionType($record[6]);
                $newVehicle->setFuelType($record[7]);
                $newVehicle->setCityLph($record[8]);
                $newVehicle->setHighwayLph($record[9]);
                $newVehicle->setCityMpg($record[10]);
                $newVehicle->setHighwayMpg($record[11]);

                if (preg_match('/\s#$/', $record[2])) {
                    $newVehicle->setHighOutputEngine(true);
                }

                // Check if we already have this vehicle in the DB, and if so, we'll just update the fuel econ
                if (!$this->getVehicleRepository()->exists($newVehicle)) {
                    $persistedRecords++;
                    $this->getDoctrine()->getManager()->persist($newVehicle);
                    $output->writeln(sprintf("<info>Added %s %s %s</info>", $newVehicle->getYear(), $newVehicle->getModel()->getMake()->getLabel(), $newVehicle->getModel()->getLabel()));
                } else {
                    $output->writeln(sprintf("<comment>Skipped %s %s %s</comment>", $newVehicle->getYear(), $newVehicle->getModel()->getMake()->getLabel(), $newVehicle->getModel()->getLabel()));
                }

                if ($persistedRecords > 0 && $persistedRecords % 500 == 0) {
                    $this->getDoctrine()->getManager()->flush();
                }
            } else {
                // Write un-importable records to the temporary file
                fputcsv($tempFile, $record);
            }
        }

        $this->getDoctrine()->getManager()->flush();
        $this->saveTempFile($tempFile);
    }

    /**
     * @param string $make
     * @return Make
     */
    protected function getOrCreateMake($make)
    {
        $canonical = StringHelpers::getCanonical($make);

        // If this make doesn't exist, we create one and return it;
        if (!array_key_exists($canonical, $this->makes)) {
            $newMake = new Make();
            $newMake->setLabel($make);
            $newMake->setCanonicalLabel($canonical);
            $this->getDoctrine()->getManager()->persist($newMake);
            $this->makes[$canonical] = $newMake;
        }

        return $this->makes[$canonical];
    }

    /**
     * @param \Renegade\Bundle\CarImpactBundle\Entity\Make $make
     * @param string $model
     * @return Model
     */
    protected function getOrCreateModel(Make $make, $model)
    {
        $model = preg_replace('/\s#$/', '', $model);
        $canonical = StringHelpers::getCanonical($model);

        // If this make doesn't exist, we create one and return it;
        if (!array_key_exists($make->getId(), $this->models) || !array_key_exists($canonical, $this->models[$make->getId()])) {
            $newModel = new Model();
            $newModel->setMake($make);
            $newModel->setLabel($model);
            $newModel->setCanonicalLabel($canonical);
            $this->getDoctrine()->getManager()->persist($newModel);
            $this->models[$make->getId()][$canonical] = $newModel;
        }

        return $this->models[$make->getId()][$canonical];
    }

    /**
     * Check if the record is valid for import
     *
     * We're assuming a valid record is one that starts with a four digit number
     *
     * @param array $record
     * @return bool
     */
    protected function isRecordValid(array &$record)
    {
        // Records must have at least 14 columns
        if (count($record) < 14) {
            return false;
        }

        // Is the first column a four digit number (year)
        if (!preg_match('/([0-9]{4})/', $record[0])) {
            return false;
        }

        // Remove the number from the transmission type
        $record[6] = preg_replace('/\d+$/', '', $record[6]);

        // Check if the transmission/gas are valid
        if (!Vehicle::isValidFuelType($record[7]) || !Vehicle::isValidTransmissionType($record[6])) {
            return false;
        }

        return true;
    }

    protected function isFileImportable($filename)
    {
        // Can we read the file?
        if (!is_readable($filename)) {
            return false;
        }

        // Were we able to open the file?
        if (!$file = fopen($filename, 'r')) {
            return false;
        }

        // Close the file
        fclose($file);

        return true;
    }

    /**
     * Generates arrays of the makes and models keyed by their label
     */
    protected function prepareObjects()
    {
        // Performance considerations when importing multiple files
        $this->getDoctrine()->getManager()->clear();

        $currentMakes = $this->getMakeRepository()->findAll();
        $currentModels = $this->getModelRepository()->findAll();

        $this->makes = array();
        $this->models = array();

        /**
         * @var Make $make
         */
        foreach ($currentMakes as $make) {
            $this->makes[$make->getCanonicalLabel()] = $make;
            $this->models[$make->getId()] = array();
        }

        /**
         * @var Model $model
         */
        foreach ($currentModels as $model) {
            $this->models[$model->getMake()->getId()][$model->getCanonicalLabel()] = $model;
        }
    }

    /**
     * @return Registry|object
     */
    protected function getDoctrine()
    {
        if (null === $this->doctrine) {
            $this->doctrine = $this->getContainer()->get('doctrine');
        }

        return $this->doctrine;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|EntityRepository
     */
    protected function getMakeRepository()
    {
        if (null === $this->makeRepository) {
            $this->makeRepository = $this->getDoctrine()->getRepository('RenegadeCarImpactBundle:Make');
        }
        return $this->makeRepository;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|EntityRepository
     */
    protected function getModelRepository()
    {
        if (null === $this->modelRepository) {
            $this->modelRepository = $this->getDoctrine()->getRepository('RenegadeCarImpactBundle:Model');
        }
        return $this->modelRepository;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|VehicleRepository
     */
    protected function getVehicleRepository()
    {
        if (null === $this->vehicleRepository) {
            $this->vehicleRepository = $this->getDoctrine()->getRepository('RenegadeCarImpactBundle:Vehicle');
        }
        return $this->vehicleRepository;
    }

    protected function saveTempFile($file)
    {
        if (null !== $file) {
            $time = new \DateTime();
            $tempFileMeta = stream_get_meta_data($file);
            $tempFileWrapper = new File($tempFileMeta['uri']);
            $savePath = $this->getContainer()->get('kernel')->getRootDir() . '/../imports/';
            $tempFileWrapper->move($savePath, sprintf('failed-%s.txt', $time->format('hisymd')));
            fclose($file);
        }
    }
}