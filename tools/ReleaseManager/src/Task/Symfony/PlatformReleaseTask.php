<?php

namespace App\Tools\MageTools\Task\Symfony;

use Mage\Runtime\Exception\RuntimeException;
use Mage\Task\AbstractTask;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class PlatformReleaseTask extends AbstractTask
{
    public function getName(): string
    {
        return 'smaug/symfony/platform-release';
    }

    public function getDescription(): string
    {
        return '[Symfony] Platform release (update version in parameters.yml)';
    }

    public function execute(): bool
    {
        // TODO rework for local tags
        /** @var Process $process */
        $process = $this->runtime->runLocalCommand('git describe');

        if (!$process->isSuccessful()) {
            // If not successful, maybe there's no branch yet so we try getting the branch name
            /** @var Process $process */
            $process = $this->runtime->runLocalCommand('git rev-parse --abbrev-ref HEAD');

            // Still not successful
            if (!$process->isSuccessful()) {
                return false;
            }
        }

        $version = $process->getOutput();

        /** @var Process $process */
        $process = $this->runtime->runRemoteCommand('cat app/config/parameters.yml', true);

        if (!$process->isSuccessful()) {
            return false;
        }

        try {
            $params = Yaml::parse($process->getOutput());
            $params['parameters']['platform_version'] = trim($version);

            /** @var Process $process */
            $process = $this->runtime->runRemoteCommand(
                sprintf('echo %s > app/config/parameters.yml', escapeshellarg(Yaml::dump($params))),
                true
            );
        } catch (ParseException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $process->isSuccessful();
    }
}
