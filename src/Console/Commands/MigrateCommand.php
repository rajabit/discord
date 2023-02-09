<?php

namespace Rajabit\Discord\Console\Commands;

use Illuminate\Console\Command;
use Rajabit\Discord\Discord;

class MigrateCommand extends Command
{

    protected $signature = 'discord:migrate';

    protected $description = 'Migrate discord commands';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $commands = config('discord.commands');

        foreach ($commands as $inx => $prm) {
            $data = [
                "name" => $inx,
                "type" => $prm['type'],
                "description" => $prm['description'] ?? null
            ];

            $this->line("migrating: $inx");

            $res =  $prm['type'] == 1 ? Discord::makeGlobalCommand($data)
                : Discord::makeGuildCommand($prm['guild_id'], $data);

            $json = $res->json($key = null);
            $format = $res->successful() ? "info" : "error";
            $this->$format(json_encode($json, JSON_PRETTY_PRINT));
        }


        return Command::SUCCESS;
    }
}
