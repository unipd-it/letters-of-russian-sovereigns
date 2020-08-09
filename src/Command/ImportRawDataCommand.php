<?php

declare(strict_types=1);

/*
 * This file is part of «Letters of Russian sovereigns to the Republic of Venice» database.
 *
 * Copyright (c) Department of Linguistic and Literary Studies of the University of Padova
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is free software:
 * you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, version 3.
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is distributed
 * in the hope  that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. If you have not received
 * a copy of the GNU General Public License along with
 * «Letters of Russian sovereigns to the Republic of Venice» database,
 * see <http://www.gnu.org/licenses/>.
 */

namespace App\Command;

use App\Import\RawData\RawDataImporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class ImportRawDataCommand extends Command
{
    protected static $defaultName = 'app:import:raw-data';

    /**
     * @var RawDataImporterInterface
     */
    private $rawDataImporter;

    public function __construct(RawDataImporterInterface $rawDataImporter)
    {
        parent::__construct();

        $this->rawDataImporter = $rawDataImporter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import raw data')
            ->addArgument('source-directory', InputArgument::REQUIRED, 'Directory with source files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sourceDirectory = $input->getArgument('source-directory');

        $this->rawDataImporter->importRawData($sourceDirectory);

        $io->success('Raw data import successfully finished');

        return 0;
    }
}
