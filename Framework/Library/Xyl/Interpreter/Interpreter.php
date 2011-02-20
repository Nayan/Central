<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * GNU General Public License
 *
 * This file is part of HOA Open Accessibility.
 * Copyright (c) 2007, 2011 Ivan ENDERLIN. All rights reserved.
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
 */

namespace {

from('Hoa')

/**
 * \Hoa\Xyl\Element\Concrete
 */
-> import('Xyl.Element.Concrete');

}

namespace Hoa\Xyl\Interpreter {

/**
 * Class \Hoa\Xyl\Interpreter.
 *
 * 
 *
 * @author     Ivan ENDERLIN <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright (c) 2007, 2011 Ivan ENDERLIN.
 * @license    http://gnu.org/licenses/gpl.txt GNU GPL
 */

abstract class Interpreter {

    /**
     * Rank: abstract elements to concrete elements.
     *
     * @var \Hoa\Xyl\Interpreter array
     */
    protected $_rank         = array();

    /**
     * Resource path.
     *
     * @var \Hoa\Xyl\Interpreter string
     */
    protected $_resourcePath = null;



    /**
     * Get rank.
     *
     * @access  public
     * @return  array
     */
    public function getRank ( ) {

        return $this->_rank;
    }

    /**
     * Get resource path.
     *
     * @access  public
     * @return  string
     */
    public function getResourcePath ( ) {

        return $this->_resourcePath;
    }
}

}