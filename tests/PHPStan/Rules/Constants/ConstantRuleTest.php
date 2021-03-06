<?php declare(strict_types = 1);

namespace PHPStan\Rules\Constants;

/**
 * @extends \PHPStan\Testing\RuleTestCase<ConstantRule>
 */
class ConstantRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new ConstantRule();
	}

	public function testConstants(): void
	{
		define('FOO_CONSTANT', 'foo');
		define('Constants\\BAR_CONSTANT', 'bar');
		define('OtherConstants\\BAZ_CONSTANT', 'baz');
		$this->analyse([__DIR__ . '/data/constants.php'], [
			[
				'Constant NONEXISTENT_CONSTANT not found.',
				10,
			],
			[
				'Constant DEFINED_CONSTANT not found.',
				13,
			],
			/*[
				'Constant DEFINED_CONSTANT_IF not found.',
				21,
			],*/
		]);
	}

	public function testCompilerHaltOffsetConstantFalseDetection(): void
	{
		$this->analyse([__DIR__ . '/data/compiler-halt-offset-const-defined.php'], []);
	}

	public function testCompilerHaltOffsetConstantIsUndefinedDetection(): void
	{
		$this->analyse([__DIR__ . '/data/compiler-halt-offset-const-not-defined.php'], [
			[
				'Constant __COMPILER_HALT_OFFSET__ not found.',
				3,
			],
		]);
	}

}
