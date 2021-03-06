<?php

use W4P\Models\Setting;

/**
 * @author Nico Verbruggen
 * @copyright 2015 Underlined bvba
 * @link https://underlined.be
 */

class SetupStepsProjectTest extends TestCase
{
    public function testProjectFieldsEmpty()
    {
        $this->visit('/setup/4')
            ->see('Project Setup');
        $this->assertFalse(Setting::exists('project.title'));
        $this->assertFalse(Setting::exists('project.brief'));
    }

    // TODO: Unit test form submission
}