<?php /** @noinspection ALL */

namespace Dukecity\CommandSchedulerBundle\Tests\Command;

use Dukecity\CommandSchedulerBundle\Command\ExecuteCommand;
use Dukecity\CommandSchedulerBundle\Fixtures\ORM\LoadScheduledCommandData;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ExecuteCommandTest.
 */
class ExecuteCommandTest extends AbstractCommandTest
{
    /**
     * Test scheduler:execute without option.
     */
    public function testExecute()
    {
        // DataFixtures create 4 records
        $this->loadScheduledCommandFixtures();

        $output = $this->executeCommand(ExecuteCommand::class)->getDisplay();

        $this->assertStringStartsWith('Start : Execute all scheduled command', $output);
        $this->assertStringContainsString('debug:container should be executed', $output);

        # TODO reintegrate tests below (command xxx not found)
        #$this->assertStringContainsString('Execute : debug:container --help', $output);
        #$this->assertStringContainsString('Immediately execution asked for : debug:router', $output);
        #$this->assertStringContainsString('Execute : debug:router', $output);

        # the second call should show that no commands needs exceution
        #$output = $this->executeCommand(ExecuteCommand::class)->getDisplay();
        #$this->assertStringContainsString('Nothing to do', $output);
    }

    /**
     * Test scheduler:execute without option.
     */
    public function testExecuteWithNoOutput()
    {
        // DataFixtures create 4 records
        $this->loadScheduledCommandFixtures();

        $output = $this->executeCommand(ExecuteCommand::class, ['--no-output' => true])->getDisplay();

        $this->assertEquals('', $output);

        $output = $this->executeCommand(ExecuteCommand::class)->getDisplay();
        $this->assertStringContainsString('Nothing to do', $output);
    }

    /**
     * Test scheduler:execute with --dump option.
     */
    public function testExecuteWithDump()
    {
        // DataFixtures create 4 records
        $this->loadScheduledCommandFixtures();

        $output = $this->executeCommand(ExecuteCommand::class, ['--dump' => true])->getDisplay();

        $this->assertStringStartsWith('Start : Dump all scheduled command', $output);
        $this->assertStringContainsString('Command debug:container should be executed', $output);
        $this->assertStringContainsString('Immediately execution asked for : debug:router', $output);
    }
}
