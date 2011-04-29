<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2011, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @category    Framework
 * @package     Hoa_Filter
 * @subpackage  Hoa_Filter_Integer
 *
 */

/**
 * Hoa_Filter_Abstract
 */
import('Filter.Abstract');

/**
 * Class Hoa_Filter_Integer.
 *
 * Apply an integer filter.
 *
 * @author      Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright © 2007-2011 Ivan Enderlin.
 * @license     New BSD License
 * @since       PHP 5
 * @version     0.1
 * @package     Hoa_Filter
 * @subpackage  Hoa_Filter_Integer
 */

class Hoa_Filter_Integer extends Hoa_Filter_Abstract {

    /**
     * Keep integer from string.
     *
     * @const int
     */
    const KEEP = 0;

    /**
     * Cast string to integer.
     *
     * @const int
     */
    const CAST = 1;

    /**
     * Needed arguments.
     *
     * @var Hoa_Filter_Abstract array
     */
    protected $arguments = array(
        'operation' => 'specify the type of operation : KEEP (0) or CAST (1).'
    );



    /**
     * Apply an integer filter.
     *
     * @access  public
     * @param   string  $string    The string to filter.
     * @return  string
     */
    public function filter ( $string = null ) {

        if($this->getFilterArgument('operation') == self::CAST)
            return (int) (string) $string;

        elseif($this->getFilterArgument('operation') == self::KEEP)
            return preg_replace('#[^[:digit:]]#', '', (string) $string);

        return null;
    }
}