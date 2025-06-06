<?php
// This file is part of Stack - http://stack.maths.ed.ac.uk/
//
// Stack is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Stack is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Stack.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Add description here!
 * @package    qtype_stack
 * @copyright  2024 University of Edinburgh.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace qtype_stack;

use qtype_stack_testcase;
use stack_cas_keyval;
use stack_exception;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../locallib.php');
require_once(__DIR__ . '/fixtures/test_base.php');
require_once(__DIR__ . '/../stack/cas/cassession2.class.php');
require_once(__DIR__ . '/../stack/cas/keyval.class.php');

// Unit tests for {@link stack_cas_keyval} involving exceptions.

/**
 * Add description
 * @group qtype_stack
 * @covers \stack_cas_keyval
 */
final class caskeyval_exception_test extends qtype_stack_testcase {

    public function test_exception_1(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval([], false, false);
    }

    public function test_exception_2(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval(1, false, false);
    }


    public function test_exception_3(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval('x=1', false, false);
    }

    public function test_exception_4(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval('x=1', null, false);
    }

    public function test_exception_5(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval('x=1', 'z', false);
    }

    public function test_exception_7(): void {

        $this->expectException(stack_exception::class);
        $at1 = new stack_cas_keyval('x=1', 't', false);
    }

    public function test_stack_compile_unexpected_lambda(): void {

        $this->expectException(stack_exception::class);
        // This is related to issue #1279.
        $tests = 'a:b+1; c:a-a(d+1);';
        $kv = new stack_cas_keyval($tests);
        $this->asserttrue($kv->get_valid());
        $expected = [];
        $this->assertEquals($expected, $kv->get_errors());
        $kv->instantiate();
        $s = $kv->get_session();
        $s->instantiate();
        $this->assertEquals($s->get_by_key('c')->get_evaluationform(), 'c:(b+1)-(b+1)(d+1)');
    }
}
