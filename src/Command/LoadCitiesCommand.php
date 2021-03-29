<?php

namespace App\Command;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class LoadCitiesCommand extends Command
{
    protected static $defaultName = 'app:load_cities';
    protected static $defaultDescription = 'Command for loading cities from json file file';

    private $decoder;
    private $entityManager;

    private const FILE_PATH = 'storage/city.list.json';
    private const BATCH_SIZE = 10000;

    public function __construct(DecoderInterface $decoder, EntityManagerInterface $entityManager, string $name = null)
    {
        $this->decoder = $decoder;
        $this->entityManager = $entityManager;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if(!file_exists(self::FILE_PATH)) {
            $io->error('File at given path \'' . self::FILE_PATH . '\' doesn\'t exist');

            return Command::FAILURE;
        }

        if(!$this->entityManager->getRepository(City::class)->isEmpty()) {
            $io->warning('Cities are already loaded');

            return Command::SUCCESS;
        }

        $cities = $this->getCitiesFromFile();

        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger();

        foreach($cities as $key => $cityFromFile) {
            try {
                $city = new City();
                $city->setName($cityFromFile['name']);
                $city->setCountry($cityFromFile['country']);
                $city->setExternalId($cityFromFile['id']);
                $city->setLat($cityFromFile['coord']['lat']);
                $city->setLon($cityFromFile['coord']['lon']);

                $this->entityManager->persist($city);
            } catch (\Exception $e) {
                $io->error('Json content is not valid');

                return Command::FAILURE;
            }

            if($key % self::BATCH_SIZE == 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->success('Successfully loaded cities to db');

        return Command::SUCCESS;
    }

    private function getCitiesFromFile(): array
    {
        $jsonContent = file_get_contents(self::FILE_PATH);

        return $this->decoder->decode($jsonContent, 'json');
    }
}
