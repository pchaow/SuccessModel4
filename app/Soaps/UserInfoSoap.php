<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 7/13/2015
 * Time: 4:51 PM
 */

namespace App\Soaps;


use Artisaninweb\SoapWrapper\Extension\SoapService;

class UserInfoSoap extends SoapService {

    /**
     * @var string
     */
    protected $name = 'upinfo';

    /**
     * @var string
     */
    protected $wsdl = 'https://ws.up.ac.th/mobile/StaffService.asmx?WSDL';

    /**
     * @var boolean
     */
    protected $trace = true;

    /**
     * Get all the available functions
     *
     * @return mixed
     */
    public function functions()
    {
        return $this->getFunctions();
    }

}