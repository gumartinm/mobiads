<?php

/**
 * BaseOffice
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $city_id
 * @property blob $office_gps
 * @property string $office_street_address
 * @property string $office_zip
 * @property Company $Company
 * @property City $City
 * @property Doctrine_Collection $OfficeAds
 * 
 * @method integer             getCompanyId()             Returns the current record's "company_id" value
 * @method integer             getCityId()                Returns the current record's "city_id" value
 * @method blob                getOfficeGps()             Returns the current record's "office_gps" value
 * @method string              getOfficeStreetAddress()   Returns the current record's "office_street_address" value
 * @method string              getOfficeZip()             Returns the current record's "office_zip" value
 * @method Company             getCompany()               Returns the current record's "Company" value
 * @method City                getCity()                  Returns the current record's "City" value
 * @method Doctrine_Collection getOfficeAds()             Returns the current record's "OfficeAds" collection
 * @method Office              setCompanyId()             Sets the current record's "company_id" value
 * @method Office              setCityId()                Sets the current record's "city_id" value
 * @method Office              setOfficeGps()             Sets the current record's "office_gps" value
 * @method Office              setOfficeStreetAddress()   Sets the current record's "office_street_address" value
 * @method Office              setOfficeZip()             Sets the current record's "office_zip" value
 * @method Office              setCompany()               Sets the current record's "Company" value
 * @method Office              setCity()                  Sets the current record's "City" value
 * @method Office              setOfficeAds()             Sets the current record's "OfficeAds" collection
 * 
 * @package    mobiads
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOffice extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('office');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('city_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('office_gps', 'blob', null, array(
             'type' => 'blob',
             ));
        $this->hasColumn('office_street_address', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('office_zip', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 32,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('City', array(
             'local' => 'city_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasMany('OfficeAds', array(
             'local' => 'id',
             'foreign' => 'office_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}