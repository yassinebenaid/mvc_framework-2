<?php

namespace Spoot\Console;

use Spoot\Database\Mysql;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommande extends Command
{
    protected static $defaultName = "migrate";

    protected function configure()
    {
        $this->setDescription("migrate the migrations to the database engine")
            ->setHelp("this commande looks for all migration files and run them");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $current = getcwd();
        $pattern = "migration/*.php";
        $paths = glob("{$current}/{$pattern}");

        if (count($paths) < 1) {
            $output->writeln("No migration found");
            return Command::SUCCESS;
        }


        $this->createMigrationsTable();
        $appliedMigrations = $this->AppliedMigrations();

        $toAppliedMigration = array_diff($paths, $appliedMigrations);

        foreach ($toAppliedMigration as $path) {
            $class =  explode("_", pathinfo($path, PATHINFO_FILENAME))[1];

            require $path;
            (new $class())->migrate();

            Mysql::Query()->from("migrations")->insert(["migration"], [$path]);

            $output->writeln("apply $class ... ");
            sleep(1);
        }

        $output->writeln("All migrations was apllied successfully");
        return Command::SUCCESS;
    }


    private function AppliedMigrations()
    {
        return  Mysql::Query()->select("migration")->from("migrations")->getColumn();
    }

    private function createMigrationsTable()
    {
        $table = Mysql::CreateTable("migrations");
        $table->id("m_id");
        $table->varchar("migration", 255);
        $table->execute();
    }
}
