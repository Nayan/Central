<?php

/**
 * Hoa Framework
 *
 *
 * @license
 *
 * GNU General Public License
 *
 * This file is part of Hoa Open Accessibility.
 * Copyright (c) 2007, 2010 Ivan ENDERLIN. All rights reserved.
 *
 * HOA Open Accessibility is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * HOA Open Accessibility is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HOA Open Accessibility; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 * @category    Framework
 * @package     Hoa_Reflection_Fragment
 * @subpackage  Hoa_Reflection_Fragment_RMethod
 *
 */

/**
 * Hoa_Core
 */
require_once 'Core.php';

/**
 * Hoa_Reflection_RFunction_RMethod
 */
import('Reflection.RFunction.RMethod');

/**
 * Class Hoa_Reflection_Fragment_RMethod.
 *
 * Fragment of a Hoa_Reflection_RFunction_RMethod class.
 *
 * @author      Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright (c) 2007, 2010 Ivan ENDERLIN.
 * @license     http://gnu.org/licenses/gpl.txt GNU GPL
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Reflection_Fragment
 * @subpackage  Hoa_Reflection_Fragment_RMethod
 */

class Hoa_Reflection_Fragment_RMethod extends Hoa_Reflection_RFunction_RMethod {

    /**
     * Reflect a fragment of method.
     *
     * @access  public
     * @param   string  $name    Method name.
     * @return  void
     */
    public function __construct ( $name ) {

        $this->setName($name);
        $this->_firstP = false;

        return;
    }

    /**
     * Get the method body.
     *
     * @access  public
     * @return  string
     */
    public function getBody ( ) {

        return $this->_body;
    }

    /**
     * Override the ReflectionMethod method.
     *
     * @access  public
     * @return  int
     */
    public function getStartLine ( ) {

        return -1;
    }

    /**
     * Override the ReflectionMethod method.
     *
     * @access  public
     * @return  int
     */
    public function getEndLine ( ) {

        return -1;
    }

    /**
     * Override the ReflectionMethod method.
     *
     * @access  public
     * @return  int
     */
    public function getFileName ( ) {

        return null;
    }
}