<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Core;

use Cake\TestSuite\TestCase;

/**
 * Test cases for functions in Core\functions.php
 */
class FunctionsTest extends TestCase
{
    /**
     * Test cases for env()
     */
    public function testEnv()
    {
        $_ENV['DOES_NOT_EXIST'] = null;
        $this->assertNull(env('DOES_NOT_EXIST'));
        $this->assertEquals('default', env('DOES_NOT_EXIST', 'default'));

        $_ENV['DOES_EXIST'] = 'some value';
        $this->assertEquals('some value', env('DOES_EXIST'));
        $this->assertEquals('some value', env('DOES_EXIST', 'default'));

        $_ENV['EMPTY_VALUE'] = '';
        $this->assertEquals('', env('EMPTY_VALUE'));
        $this->assertEquals('', env('EMPTY_VALUE', 'default'));

        $_ENV['ZERO'] = '0';
        $this->assertEquals('0', env('ZERO'));
        $this->assertEquals('0', env('ZERO', '1'));
    }

    /**
     * Test error messages coming out when debug is on, manually setting the stack frame
     *
     * @expectedException PHPUnit\Framework\Error\Deprecated
     * @expectedExceptionMessageRegExp /This is going away - (.*?)[\/\\]FunctionsTest.php, line\: \d+/
     */
    public function testDeprecationWarningEnabled()
    {
        $this->withErrorReporting(E_ALL, function () {
            deprecationWarning('This is going away', 2);
        });
    }

    /**
     * Test error messages coming out when debug is on, not setting the stack frame manually
     *
     * @expectedException PHPUnit\Framework\Error\Deprecated
     * @expectedExceptionMessageRegExp /This is going away - (.*?)[\/\\]TestCase.php, line\: \d+/
     */
    public function testDeprecationWarningEnabledDefaultFrame()
    {
        $this->withErrorReporting(E_ALL, function () {
            deprecationWarning('This is going away');
        });
    }

    /**
     * Test no error when debug is off.
     *
     * @return void
     */
    public function testDeprecationWarningLevelDisabled()
    {
        $this->withErrorReporting(E_ALL ^ E_USER_DEPRECATED, function () {
            $this->assertNull(deprecationWarning('This is going away'));
        });
    }

    /**
     * testing getTypeName()
     *
     * @return void
     */
    public function testgetTypeName()
    {
        $this->assertEquals('stdClass', getTypeName(new \stdClass()));
        $this->assertEquals('array', getTypeName([]));
        $this->assertEquals('string', getTypeName(''));
    }
}