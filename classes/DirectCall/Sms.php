<?php

/**
 *
 */

namespace DirectCall;

use DirectCall\DirectCall;
use DirectCall\Exception;
use DirectCall\Module\SmsModule;

/**
 *
 */
class Sms {

    private static $instance;
    private $directcall;

    private function __construct() {
        \Config::load('directcall', true);
        if (empty(\Config::get('directcall.credentials'))) {
            throw new Exception('credentials must be set in config');
        }
        $this->directcall = new DirectCall(\Config::get('directcall.credentials.clientId'), \Config::get('directcall.credentials.clientSecret'));
        if (empty($this->directcall->authenticate())) {
            throw new Exception('credentials must be set in config');
        }
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     */
    public function sendSMS($fromTel, $toTel, $msg) {
        return (new Module\SmsModule($this->directcall))->send($fromTel, $toTel, $msg);
    }

    /**
     *
     */
    public function getStatus($callerid) {
        return (new Module\SmsModule($this->directcall))->status($callerid);
    }

}