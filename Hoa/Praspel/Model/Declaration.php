<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2014, Ivan Enderlin. All rights reserved.
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
 */

namespace {

from('Hoa')

/**
 * \Hoa\Praspel\Exception\Model
 */
-> import('Praspel.Exception.Model')

/**
 * \Hoa\Praspel\Model\Clause
 */
-> import('Praspel.Model.Clause')

/**
 * \Hoa\Praspel\Model\Variable
 */
-> import('Praspel.Model.Variable.~')

/**
 * \Hoa\Praspel\Model\Variable\Borrowing
 */
-> import('Praspel.Model.Variable.Borrowing')

/**
 * \Hoa\Realdom\Crate\Variable
 */
-> import('Realdom.Crate.Variable')

/**
 * \Hoa\Realdom\Crate\Constant
 */
-> import('Realdom.Crate.Constant')

/**
 * \Hoa\Iterator\Aggregate
 */
-> import('Iterator.Aggregate')

/**
 * \Hoa\Iterator\CallbackFilter
 */
-> import('Iterator.CallbackFilter')

/**
 * \Hoa\Iterator\Map
 */
-> import('Iterator.Map');

}

namespace Hoa\Praspel\Model {

/**
 * Class \Hoa\Praspel\Model\Declaration.
 *
 * Represent a declaration.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2014 Ivan Enderlin.
 * @license    New BSD License
 */

abstract class Declaration
    extends    Clause
    implements \Hoa\Iterator\Aggregate,
               \ArrayAccess,
               \Countable {

    /**
     * Declared variables.
     *
     * @var \Hoa\Praspel\Model\Declaration array
     */
    protected $_variables  = array();

    /**
     * Predicates.
     *
     * @var \Hoa\Praspel\Model\Declaration array
     */
    protected $_predicates = array();

    /**
     * Whether declaring a local variable or not.
     *
     * @var \Hoa\Praspel\Model\Declaration bool
     */
    protected $_let        = false;



    /**
     * Check if a variable exists.
     *
     * @access  public
     * @param   string  $offset    Variable name.
     * @return  bool
     */
    public function offsetExists ( $offset ) {

        return isset($this->_variables[$offset]);
    }

    /**
     * Get or create a variable.
     *
     * @access  public
     * @param   string  $offset    Variable name.
     * @return  \Hoa\Praspel\Model\Variable
     */
    public function offsetGet ( $offset ) {

        return $this->getVariable($offset);
    }

    /**
     * Declare or get a new variable.
     *
     * @access  public
     * @param   string  $name         Variable name.
     * @param   bool    $borrowing    Borrowing variable or not.
     * @return  mixed
     */
    public function getVariable ( $name, $borrowing = false ) {

        if(true === $borrowing) {

            $out        = new Variable\Borrowing($name, $this->_let, $this);
            $this->_let = false;

            return $out;
        }

        if('\old(' === substr($name, 0, 5)) {

            $variable = $this->getVariable($name, true);

            return new \Hoa\Realdom\Crate\Constant(
                $variable->getBorrowedVariable(),
                function ( ) use ( $variable ) {

                    return $variable->getName();
                },
                $this
            );
        }

        if(false === $this->offsetExists($name)) {

            $variable   = new Variable($name, $this->_let, $this);
            $this->_let = false;

            return $this->_variables[$name] = $variable;
        }

        return $this->_variables[$name];
    }

    /**
     * Add a variable.
     *
     * @access  public
     * @param   string                       $name        Name.
     * @param   \Hoa\Praspel\Model\Variable  $variable    Variable.
     * @return  \Hoa\Praspel\Model\Variable
     */
    public function addVariable ( $name, Variable $variable ) {

        return $this->_variables[$name] = $variable;
    }

    /**
     * Set a value to a variable.
     *
     * @access  public
     * @param   string  $offset    Variable name.
     * @param   mixed   $value     Variable value.
     * @return  mixed
     */
    public function offsetSet ( $offset, $value ) {

        $variable = $this->offsetGet($offset);
        $old      = $variable->getValue();
        $variable->setValue($value);

        return $old;
    }

    /**
     * Delete a variable.
     *
     * @access  public
     * @param   string  $offset    Variable name.
     * @return  void
     */
    public function offsetUnset ( $offset ) {

        unset($this->_variables[$offset]);

        return;
    }

    /**
     * Allow to write $clause->let['var'] = … to define a local variable (if
     * $name is not equal to "let", then it is a normal behavior).
     *
     * @access  public
     * @param   string  $name     Name.
     * @return  \Hoa\Praspel\Model\Declaration
     */
    public function __get ( $name ) {

        if('let' !== $name)
            return $this->$name;

        $this->_let = true;

        return $this;
    }

    /**
     * Iterator over local variables.
     *
     * @access  public
     * @return  \Hoa\Iterator\CallbackFilter
     */
    public function getIterator ( ) {

        return new \Hoa\Iterator\CallbackFilter(
            new \Hoa\Iterator\Map($this->getLocalVariables()),
            function ( Variable $variable ) {

                return false === $variable->isLocal();
            }
        );
    }

    /**
     * Count number of variables.
     *
     * @access  public
     * @return  int
     */
    public function count ( ) {

        return count($this->_variables);
    }

    /**
     * Get local variables.
     *
     * @access  public
     * @return  array
     */
    public function &getLocalVariables ( ) {

        return $this->_variables;
    }

    /**
     * Get in-scope variables.
     *
     * @access  public
     * @return  array
     */
    public function getInScopeVariables ( ) {

        $out     = array();
        $clause  = $this->getName();
        $current = $this;

        while(null !== $current = $current->getParent()) {

            if(false === $current->clauseExists($clause))
                continue;

            $localVariables = &$current->getClause($clause)->getLocalVariables();

            foreach($localVariables as $name => &$variables)
                $out[$name] = &$variables;
        }

        return $out;
    }

    /**
     * Add a predicate.
     *
     * @access  public
     * @param   string  $predicate    Predicate.
     * @return  \Hoa\Praspel\Model\Declaration
     */
    public function predicate ( $predicate ) {

        $this->_predicates[] = $predicate;

        return $this;
    }

    /**
     * Get all predicates.
     *
     * @access  public
     * @return  array
     */
    public function getPredicates ( ) {

        return $this->_predicates;
    }
}

}
