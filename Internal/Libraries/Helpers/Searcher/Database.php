<?php namespace ZN\Helpers\Searcher;

use DB, stdClass;

class Database
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Result
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //--------------------------------------------------------------------------------------------------------
    protected $result;

    //--------------------------------------------------------------------------------------------------------
    // Word
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $word;

    //--------------------------------------------------------------------------------------------------------
    // Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $type;

    //--------------------------------------------------------------------------------------------------------
    // Filter
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //--------------------------------------------------------------------------------------------------------
    protected $filter = [];

    //--------------------------------------------------------------------------------------------------------
    // Filter
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $column
    // @param string $value
    //
    //--------------------------------------------------------------------------------------------------------
    public function filter(String $column, $value) : Database
    {
        $this->_filter($column, $value, 'and');

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Filter
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $column
    // @param string $value
    //
    //--------------------------------------------------------------------------------------------------------
    public function orFilter(String $column, $value) : Database
    {
        $this->_filter($column, $value, 'or');

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Word
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $word
    //
    //--------------------------------------------------------------------------------------------------------
    public function word(String $word) : Database
    {
        $this->word = $word;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $type
    //
    //--------------------------------------------------------------------------------------------------------
    public function type(String $type) : Database
    {
        $this->type = $type;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // Database
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array  $conditions
    // @param string $word
    // @param string $type: auto, inside, equal, starting, ending
    //
    //--------------------------------------------------------------------------------------------------------
    public function do(Array $conditions, String $word = NULL, String $type = 'auto') : stdClass
    {
        if( ! empty($this->type) )
        {
            $type = $this->type ;
        }

        if( ! empty($this->word) )
        {
            $word = $this->word ;
        }

        $word     = addslashes($word);
        $operator = ' like ';
        $str      = $word;

        if( $type === 'equal')
        {
            $operator = ' = ';
        }
        elseif( $type === 'auto' )
        {
            if( is_numeric($word) )
            {
                $operator = ' = ';
            }
            else
            {
                $str = DB::like($word, 'inside');
            }
        }
        else
        {
            $str = DB::like($word, $type);
        }

        foreach( $conditions as $key => $values )
        {
            DB::distinct();

            foreach( $values as $keys )
            {
                DB::where($keys.$operator, $str, 'or');

                if( ! empty($this->filter) )
                {
                    foreach( $this->filter as $val )
                    {
                        $exval = explode('|', $val);

                        if( $exval[2] === 'and' )
                        {
                            DB::where($exval[0], $exval[1], 'and');
                        }

                        if( $exval[2] === 'or' )
                        {
                            DB::where($exval[0], $exval[1], 'or');
                        }
                    }
                }
            }

            $this->result[$key] = DB::get($key)->result();
        }

        $result = $this->result;

        $this->result = NULL;
        $this->type   = NULL;
        $this->word   = NULL;
        $this->filter = [];

        return (object) $result;
    }

    //--------------------------------------------------------------------------------------------------------
    // Protected Filter
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $column
    // @param string $value
    // @param string $type
    //
    //--------------------------------------------------------------------------------------------------------
    protected function _filter($column, $value, $type)
    {
        $this->filter[] = "$column|$value|$type";
    }
}
