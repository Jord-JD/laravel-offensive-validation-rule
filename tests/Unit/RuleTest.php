<?php

namespace JordJD\LaravelOffensiveValidationRule\Tests\Unit;

use JordJD\IsOffensive\OffensiveChecker;
use JordJD\LaravelOffensiveValidationRule\Offensive;
use JordJD\LaravelOffensiveValidationRule\Tests\TestCase;

class RuleTest extends TestCase
{
    private function rulePasses(Offensive $rule, string $value): bool
    {
        return $rule->passes('value', $value);
    }

    public function testOffensiveValues()
    {
        $rule = new Offensive();
        $values = [
            'xxxSexyxxx',
            'Big-s-e-x-y',
            'DICK',
            'shitcrapper500',
            'c-u-n-t-asaurus',
            'm0therfuker',
            'firstFaggot',
            'Sh1tface',
            'Twatter9000',
            'Ultim8Cun7',
        ];

        foreach ($values as $value) {
            $this->assertFalse($this->rulePasses($rule, $value), 'Failed asserting that \''.$value.'\' is offensive.');
        }
    }

    public function testNotOffensiveValues()
    {
        $rule = new Offensive();
        $values = [
            'test',
            'user',
            'Frank',
            'Francis',
            'apple',
            'orange',
            'bananas',
            'middlesex',
            'scunthorpe',
        ];

        foreach ($values as $value) {
            $this->assertTrue($this->rulePasses($rule, $value), 'Failed asserting that \''.$value.'\' is not offensive.');
        }
    }

    private function getCustomRule(): Offensive
    {
        $blacklist = ['moist', 'stinky', 'poo'];
        $whitelist = ['poop'];

        return new Offensive(new OffensiveChecker($blacklist, $whitelist));
    }

    public function testCustomBlacklistAndWhitelist()
    {
        $rule = $this->getCustomRule();
        $passingValues = ['cheese', 'poop', 'poops'];
        $failingValues = ['moist', 'moistness', 'stinky', 'poo', 'poos'];

        foreach ($passingValues as $value) {
            $this->assertTrue($this->rulePasses($rule, $value));
        }

        foreach ($failingValues as $value) {
            $this->assertFalse($this->rulePasses($rule, $value));
        }
    }

    public function testNonStringValuesAreLeftToOtherValidationRules()
    {
        $rule = new Offensive();
        $values = [null, 123, false, [], new \stdClass()];

        foreach ($values as $value) {
            $this->assertTrue($rule->passes('value', $value));
        }
    }

    public function testStringableValuesAreChecked()
    {
        $value = new class() {
            public function __toString()
            {
                return 'shitcrapper500';
            }
        };

        $this->assertFalse((new Offensive())->passes('value', $value));
    }

    public function testValidationMessageCanBeCustomized()
    {
        $rule = new Offensive(null, 'Choose a different :attribute.');

        $this->assertSame('Choose a different :attribute.', $rule->message());
    }

    public function testEmptyValidationMessageIsRejected()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Offensive(null, ' ');
    }
}
