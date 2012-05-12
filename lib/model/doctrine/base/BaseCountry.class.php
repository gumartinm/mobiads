<?php

/**
 * BaseCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $country_name
 * @property string $iso_code_2
 * @property string $iso_code_3
 * @property Doctrine_Collection $Region
 * 
 * @method string              getCountryName()  Returns the current record's "country_name" value
 * @method string              getIsoCode2()     Returns the current record's "iso_code_2" value
 * @method string              getIsoCode3()     Returns the current record's "iso_code_3" value
 * @method Doctrine_Collection getRegion()       Returns the current record's "Region" collection
 * @method Country             setCountryName()  Sets the current record's "country_name" value
 * @method Country             setIsoCode2()     Sets the current record's "iso_code_2" value
 * @method Country             setIsoCode3()     Sets the current record's "iso_code_3" value
 * @method Country             setRegion()       Sets the current record's "Region" collection
 * 
 * @package    mobiads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCountry extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('country');
        $this->hasColumn('country_name', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 80,
             ));
        $this->hasColumn('iso_code_2', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('iso_code_3', 'string', 3, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 3,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Region', array(
             'local' => 'id',
             'foreign' => 'country_id'));
    }
}