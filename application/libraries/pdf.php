<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pdf extends Dompdf
{
    function __construct()
    {
        parent::__construct();
    }
}